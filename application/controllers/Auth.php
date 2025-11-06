<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');

    }

    public function index() {
        if($this->session->userdata('logged_in')) {
            switch($this->session->userdata('role')) {
                case 'administrador':
                    redirect('admin');
                    break;
                case 'recepcionista':
                    redirect('recepcionista');
                    break;
                case 'veterinario':
                    redirect('veterinario');
                    break;
                default:
                    redirect('user/index');
            }
        }
        $this->load->view('auth/login');
    }

    public function login() {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $usuario = $this->User_model->get_by_email($email);
            
            if (!$usuario) {
                $this->session->set_flashdata('error', 'El correo ingresado no existe en nuestros registros');
                $this->session->set_userdata('mostrar_error', true);
                redirect('auth/login');
            }
            
            if (password_verify($password, $usuario->password)) {
                $session_data = array(
                    'usuario_id' => $usuario->id,
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'role' => $usuario->role,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);
                

                
                // Redirigir según el rol
                switch($usuario->role) {
                    case 'administrador':
                        redirect('admin');
                        break;
                    case 'veterinario':
                        redirect('veterinario');
                        break;
                    case 'recepcionista':
                        redirect('recepcionista');
                        break;
                    default:
                        redirect('user');
                }
            } else {
                $this->session->set_flashdata('error', 'Contraseña incorrecta');
                $this->session->set_userdata('mostrar_error', true);
                redirect('auth/login');
            }
        }
        
        $this->load->view('auth/login');
    }

    public function register() {
        if($this->input->method() === 'post') {
            $this->load->library('form_validation');
            
            $this->form_validation->set_message('is_unique', 'El %s ya está registrado en el sistema');
            $this->form_validation->set_message('valid_email', 'El campo %s debe contener una dirección de correo válida');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length', 'El campo %s debe tener al menos %s caracteres');
            $this->form_validation->set_message('matches', 'Las contraseñas no coinciden');
            
            $this->form_validation->set_rules('rut', 'RUT', 'required|is_unique[users.rut]');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('direccion', 'Dirección', 'required');
            $this->form_validation->set_rules('telefono', 'Teléfono', 'required');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'required|matches[password]');
            
            if($this->form_validation->run()) {
                $datos = array(
                    'rut' => $this->input->post('rut'),
                    'nombre' => $this->input->post('nombre'),
                    'email' => $this->input->post('email'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $this->input->post('telefono'),
                    'password' => $this->input->post('password'),
                    'role' => 'usuario'  // Este está correcto, lo dejamos así
                );
                
                if($this->User_model->crear($datos)) {

                    
                    $this->session->set_flashdata('success', 'Usuario registrado exitosamente. Por favor inicia sesión.');
                    redirect('auth');
                } else {
                    $this->session->set_flashdata('error', 'Error al registrar el usuario. Por favor intenta nuevamente.');
                    redirect('auth/register');
                }
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('auth/register');
            }
        }
        
        $this->load->view('auth/register');
    }

    // Agregar método logout
    public function logout() {


        $this->session->sess_destroy();
        redirect('auth/login');
    }
    
    // Añade este método al controlador Auth
    public function check_role() {
        // Si el usuario no ha iniciado sesión, redirigir al login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
            return;
        }
        
        $role = $this->session->userdata('role');
        $current_controller = $this->router->fetch_class();
        
        // Permitir acceso según el rol
        switch($role) {
            case 'administrador':
                if ($current_controller !== 'admin') {
                    redirect('admin/dashboard');
                }
                break;
            case 'recepcionista':
                if ($current_controller !== 'recepcionista') {
                    redirect('recepcionista');
                }
                break;
            case 'veterinario':
                if ($current_controller !== 'veterinario') {
                    redirect('veterinario/dashboard');
                }
                break;
            default:
                if ($current_controller !== 'user') {
                    redirect('user/index');
                }
        }
    }
}