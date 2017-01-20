<?
class Paypal extends Controller
{

    function index(){
        $cart = new ShoppingCart(30);
        $cart->payAmount();
    }
    function success()
    {
       echo "Success";
    }

    function cancel()
    {
        echo "Cancel";
    }

    function ipn()
    {

    }

}