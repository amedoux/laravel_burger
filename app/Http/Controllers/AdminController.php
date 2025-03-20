<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\Food;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use App\Mail\OrderReadyMail;

class AdminController extends Controller
{
    public function add_food()
    {

        return view('admin.add_food');

    }



    public function upload_food(Request $request)
    {
        $data = new Food;

        $data->title = $request->title;

        $data->detail = $request->details;

        $data->price = $request->price;

        $image = $request->img;

        $filename = time().'.'.$image->getClientOriginalExtension();

        $request->img->move('food_img', $filename );

        $data->image = $filename ;


        $data->save();

        return redirect()->back();


    }


    public function view_food()
    {

        $data = Food::all();
        return view('admin.show_food',compact('data'));
    }


    public function delete_food($id)
    {
        $data = Food::find($id);

        $data->delete();

        return redirect()->back();
    }


    public function update_food($id)
    {

        $food = Food::find($id);
        return view('admin.update_food',compact('food'));
    }


    public function edit_food(Request $request,$id)
    {

        $data = Food::find($id);

        $data->title = $request->title;
        $data->detail = $request->details;
        $data->price = $request->price; 


        $image = $request->image;
        if($image)
        {
            $imagename=time().'.'.$image->getClientOriginalExtension();

            $request->image->move('food_img',$imagename);

            $data->image =  $imagename;
        }



        $data->save();

        return redirect('view_food');
    }


    public function orders()
    {

        $data = Order::all();

        return view('admin.order',compact('data'));
    }

    public function on_the_way($id)
    {
        $data = Order::find($id);

        $data->delivery_status = "En route";

        $data->save();

        return redirect()->back();
    }


    public function delivered($id)
    {
        try {
            $data = Order::find($id);
            $data->delivery_status = "Payée";
            $data->payment_date = now();
            // Convertir le prix en nombre si nécessaire
            $data->payment_amount = is_numeric($data->price) ? $data->price : floatval(str_replace(['fr', ','], ['', '.'], $data->price));
            $data->save();

            return redirect()->back()->with('success', 'Commande marquée comme payée.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du paiement : ' . $e->getMessage());
        }
    }


    public function canceled($id)
    {
        $data = Order::find($id);

        $data->delivery_status = "Annuler";

        $data->save();

        return redirect()->back();
    }

    public function pending($id)
    {
        $data = Order::find($id);

        $data->delivery_status = "En attente";

        $data->save();

        return redirect()->back();
    }
    


    public function ready($id)
    {
        try {
            $data = Order::find($id);
            $data->delivery_status = "Prête";
            $data->save();

            // Envoi de l'email avec la facture PDF
            if ($data->email) {
                Mail::to($data->email)->send(new OrderReadyMail($data));
            }

            return redirect()->back()->with('success', 'Commande marquée comme prête et email envoyé au client.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

    public function reservations()
    {

        $book = Book::all();
        return view('admin.reservation',compact('book'));
    }

    public function toggle_manager_status($id)
    {
        $manager = User::find($id);
        if($manager && $manager->usertype === 'gestionnaire')
        {
            $manager->is_active = !$manager->is_active;
            $manager->save();
        }
        return redirect()->back();
    }

    public function delete_manager($id)
    {
        $manager = User::find($id);
        if($manager && $manager->usertype === 'gestionnaire')
        {
            $manager->delete();
        }
        return redirect()->back();
    }

    public function managers()
    {
        $managers = User::where('usertype', 'gestionnaire')->get();
        return view('admin.managers', compact('managers'));
    }

    public function statistics()
    {
        // Commandes en cours de la journée
        $today_orders = Order::whereDate('created_at', today())->get();
        $pending_orders = $today_orders->where('delivery_status', 'En attente')->count();
        $preparing_orders = $today_orders->where('delivery_status', 'En préparation')->count();
        $ready_orders = $today_orders->where('delivery_status', 'Prête')->count();
        
        // Commandes validées de la journée
        $completed_orders = $today_orders->where('delivery_status', 'Payée')->count();
        
        // Recettes journalières
        $daily_revenue = $today_orders->where('delivery_status', 'Payée')->sum('payment_amount');
        
        // Nombre de commandes par mois
        $monthly_orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();
            
        // Nombre de produits par catégorie par mois
        $monthly_products = Food::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        return view('admin.statistics', compact(
            'pending_orders',
            'preparing_orders',
            'ready_orders',
            'completed_orders',
            'daily_revenue',
            'monthly_orders',
            'monthly_products'
        ));
    }

    public function register_manager(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required|min:8'
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->password = bcrypt($request->password);
            $user->usertype = 'gestionnaire';
            $user->is_active = true;

            if($user->save()) {
                return redirect()->back()->with('success', 'Gestionnaire ajouté avec succès');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement du gestionnaire');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function edit_manager($id)
    {
        $manager = User::find($id);
        if($manager && $manager->usertype === 'gestionnaire') {
            return view('admin.edit_manager', compact('manager'));
        }
        return redirect()->back();
    }

    public function update_manager(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required',
            'address' => 'required'
        ]);

        $manager = User::find($id);
        if($manager && $manager->usertype === 'gestionnaire') {
            $manager->name = $request->name;
            $manager->email = $request->email;
            $manager->phone = $request->phone;
            $manager->address = $request->address;
            if($request->password) {
                $manager->password = bcrypt($request->password);
            }
            $manager->save();
        }

        return redirect()->route('managers')->with('message', 'Gestionnaire modifié avec succès');
    }

    public function markNotificationsAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

}
