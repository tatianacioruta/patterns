<?
class Map extends Controller
{

    public function index()
    {
        $this->view->load('map/maps_view');
    }


    public function get_markers_info(){

        $map_model = new Map_model();
        $markers = $map_model->get_all();
        print_r(json_encode($markers));
    }

   }