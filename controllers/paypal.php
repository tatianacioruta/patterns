<?
class Paypal extends Controller
{

    function index(){
        $cart = new shoppingCart(30);
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