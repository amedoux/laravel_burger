<!DOCTYPE html>
<html>
<head>
    <title>Commande Prête</title>
</head>
<body>
    <h2>Bonjour {{ $order->name }},</h2>
    
    <p>Votre commande est maintenant prête !</p>
    
    <h3>Détails de la commande :</h3>
    <ul>
        <li>Produit : {{ $order->title }}</li>
        <li>Quantité : {{ $order->quantity }}</li>
        <li>Prix : {{ $order->price }} €</li>
    </ul>
    
    <p>Vous trouverez votre facture en pièce jointe.</p>
    
    <p>Merci de votre confiance !</p>
    
    <p>Cordialement,<br>L'équipe ISI BURGER</p>
</body>
</html> 