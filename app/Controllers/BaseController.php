<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{

    /**
     * Database connection instance.
     *
     * @var \CodeIgniter\Database\BaseConnection
     */
    protected $db;

    /**
     * Validation.
     */
    protected $validator;
    
    protected $id_login;
    protected $id_cabang;

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->db = \Config\Database::connect();
        $this->validator = \Config\Services::validation();
        $this->id_login = session()->get('user_id') ?? 1;
        $this->id_cabang = session('selected_akses');
        session();
        helper('form');

        // E.g.: $this->session = service('session');


        if (session('user_type') == 'admin'){
            $akses = [];
            $builder = $this->db->table('users_cabang')->select('cabang.id_cabang, cabang.nama_cabang');
            $builder->join('cabang', 'cabang.id_cabang = users_cabang.cabang_id');
            $builder->where('users_cabang.user_id', $this->id_login);
            $results = $builder->get()->getResultArray();

             foreach ($results as $row) {
                $akses[] = $row['id_cabang'];
            }

            session()->set('akses_cabang', $akses);
        }
    }
}
