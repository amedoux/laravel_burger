<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Food;

use App\Models\Order;

use App\Models\Book;

use App\Models\Cart;

use App\Notifications\NewOrderNotification;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class HomeController extends Controller
{


    public function my_home()
    {
        $data = Food::all();

        return view('home.index',compact('data'));
    }

    public function index()
    {
        if(Auth::id())
        {
            $usertype = Auth()->user()->usertype;

            if($usertype == User::ROLE_USER)
            {
                $data = Food::all();
                return view('home.index',compact('data'));
            }
            elseif($usertype == User::ROLE_MANAGER)
            {
                $total_user = User::where('usertype', '=', User::ROLE_USER)->count();
                $total_food = Food::count();
                $total_order = Order::count();
                $total_delivered = Order::where('delivery_status','=','Payée')->count();

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

                return view('admin.index', compact(
                    'total_user',
                    'total_food',
                    'total_order',
                    'total_delivered',
                    'pending_orders',
                    'preparing_orders',
                    'ready_orders',
                    'completed_orders',
                    'daily_revenue',
                    'monthly_orders',
                    'monthly_products'
                ));
            }
            elseif($usertype == User::ROLE_ADMIN)
            {
                $managers = User::where('usertype', '=', User::ROLE_MANAGER)->get();
                return view('admin.managers', compact('managers'));
            }
        }
    }


    public function add_cart(Request $request, $id)
    {
        if(Auth::id())
        {
            try {
                $food = Food::findOrFail($id);
                
                $cart = new Cart();
                $cart->title = $food->title;
                $cart->details = $food->detail;
                $cart->price = $request->qty * floatval(str_replace('fr', '', $food->price));
                $cart->image = $food->image;
                $cart->quantity = $request->qty;
                $cart->userid = Auth::id();
                
                if($cart->save()) {
                    return redirect()->back()->with('message', 'Produit ajouté au panier avec succès');
                } else {
                    return redirect()->back()->with('error', 'Erreur lors de l\'ajout au panier');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage());
            }
        }
        
        return redirect('login');
    }

    public function my_cart()
    {
        $user_id = Auth()->user()->id;

        $data = Cart::where('userid','=',$user_id)->get();

        return view('home.my_cart',compact('data'));
    }


    public function remove_cart($id)
    {
        $data = Cart::find($id);
        $data->delete();
        return redirect()->back();
    }


    public function confirm_order(Request $request)
    {
        try {
            $user = Auth::user();
            $data = Cart::where('userid', '=', $user->id)->get();

            foreach($data as $data)
            {
                $order = new Order;
                $order->title = $data->title;
                $order->price = $data->price;
                $order->quantity = $data->quantity;
                $order->name = $request->name;
                $order->phone = $request->phone;
                $order->address = $request->address;
                $order->user_id = $user->id;
                $order->delivery_status = "En attente";
                $order->save();

                // Notifier tous les gestionnaires
                $managers = User::where('usertype', User::ROLE_MANAGER)
                              ->where('is_active', true)
                              ->get();
                
                foreach($managers as $manager) {
                    $manager->notify(new NewOrderNotification($order));
                }

                $cart = Cart::find($data->id);
                $cart->delete();
            }

            return redirect()->back()->with('message', 'Commande confirmée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la confirmation de la commande : ' . $e->getMessage());
        }
    }


    public function book_table(Request $request)
    {

        $data = new Book;

        $data->phone = $request->phone;

        $data->guest = $request->n_guest;

        $data->time = $request->time; 

        $data->date = $request->date;


        $data->save();

        return redirect()->back();
    }











}
