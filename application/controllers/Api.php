<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {
  function  __construct()
  {
      parent::__construct();
      $this->load->model('M_api');
  }

  public function index_get()
  {
    $info = $this->M_api->rekap_suspect();
    $name = 'papua';

    foreach($info as $item){
        $posts[] = array(
            'name'       => $name,
            'confirm'    => $item->Confirm,
            'perawatan'  => $item->Positif,
            'sembuh'     => $item->Sembuh,
            'meninggal'  => $item->Meninggal
        );
    }

    if ($info) {
      $this->response([
        'status'  => true,
        'result'  => $posts
      ], REST_Controller::HTTP_OK);
    }
  }

  function kabupaten_get()
  {
    $id = $this->get('id_kabupaten');

    if($id === null) {
      $kabkota = $this->M_api->rekapkabkota();

      foreach($kabkota as $item){
        $posts[] = array(
            'id_kabupaten'  => $item->id_kabupaten,
            'kabkota'       => $item->nama_kab,
            'confirm'       => $item->confirm,
            'perawatan'     => $item->positif,
            'meninggal'     => $item->meninggal,
            'sembuh'        => $item->sembuh,
        );
      }

      if ($kabkota) {
        $this->response([
          'status'  => true,
          'result'  => $posts
        ], REST_Controller::HTTP_OK);
      }
    }
    else {
      $kabkota = $this->M_api->rekapkabkota($id);

      foreach($kabkota as $item){
        $posts[] = array(
            'id_kabupaten'  => $item->id_kabupaten,
            'kabkota'       => $item->nama_kab,
            'confirm'       => $item->confirm,
            'perawatan'     => $item->positif,
            'meninggal'     => $item->meninggal,
            'sembuh'        => $item->sembuh,
        );
      }

      if ($kabkota) {
        $this->response([
          'status'      => true,
          'id_kabupaten'=> $id,
          'result'      => $posts,
        ], REST_Controller::HTTP_OK);
      } else {
          $this->response([
            'status'      => false,
            'message'    => 'Data Not Found' 
        ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
  }

  function suspect_get()
  {
    $suspect = $this->M_api->suspect();

    foreach($suspect as $item){
        $posts[] = array(
            'id_suspect'    => $item->id_suspect,
            'kabupaten'     => $item->nama_kab,
            'umur'          => $item->umur,
            'gender'        => $item->gender,
            'alamat'        => $item->alamat,
            'rumah_sakit'   => $item->rumah_sakit,
            'status'        => $item->status_pasien,
            'date_created'  => $item->date_created
        );
    }

    if ($suspect) {
      $this->response([
        'status'  => true,
        'result' => $posts
      ], REST_Controller::HTTP_OK);
    }
  }

  public function prosentase_get()
  {
    $prosentase = $this->M_api->prosentase_suspect();

    foreach($prosentase as $item){
        $posts[] = array(
            'p_positif'   => number_format($item->p_positif,1),
            'p_sembuh'    => number_format($item->p_sembuh,1),
            'p_meninggal' => number_format($item->p_meninggal,1)
        );
    }

    if ($prosentase) {
      $this->response([
        'status'  => true,
        'result'  => $posts
      ], REST_Controller::HTTP_OK);
    }
  }
}