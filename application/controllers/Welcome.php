<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function user_login()
	{
		extract($_POST);
		$data =[
		'email'=>$email,
		'password'=>$password,
		];
			$ch = curl_init('http://127.0.0.1:8000/api/login');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, "user@gmail.com:user@123");
			$response = curl_exec($ch);
			curl_close($ch);
			
			// Process your response here
			$obj = (array)json_decode($response);
			if(isset($obj['data']->id))
			{				
				$this->session->set_userdata('user_id',$obj['data']->id);
				$this->session->set_userdata('email',$email);
				$this->session->set_userdata('password',$password);
				redirect(site_url().'courses-list');
			}
			else
			{
				redirect(site_url().'welcome');
			}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url().'welcome');	
	}
	public function courses()
	{
			// Send the POST request with cURL
			$ch = curl_init('http://127.0.0.1:8000/api/courses');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
			$response = curl_exec($ch);
			curl_close($ch);
			
			// Process your response here
			$obj = (array)json_decode($response);
			$res['bdata'] = json_decode($response);
			// echo $obj['data']->path;exit;
			// echo "<pre>"; print_r($obj);exit;
				$this->load->library('pagination');
				$config['base_url'] = base_url() . "page-courses-list/";
				$config['total_rows'] = $obj['data']->total;
				$config['per_page'] = $obj['data']->per_page;
				$this->pagination->initialize($config);
				$obj["links"] = $this->pagination->create_links();
				
		$this->load->view('courses_dashboard',$res);
	}
	public function createCourse(){
		extract($_POST);
		$data = [
		'title' => $title,
		'description' => $description,
		'instructor' => $instructor,
		'duration' => $duration,
		];
		
			$ch = curl_init('http://127.0.0.1:8000/api/create-course');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
			$response = curl_exec($ch);
			curl_close($ch);
			
			// Process your response here
			$obj['bdata'] = json_decode($response);
			if(isset($obj['data']->id))
			{	
				$this->session->set_flashdata('flash_message', 'Course created successfully');
			}
			else
			{
				$this->session->set_flashdata('flash_message', 'Failed course creation successfully');
			}
		redirect(site_url().'courses-list');
	}
	public function course_update_view($id)
	{
		$data = ['id'=>$id];
		$url = 'http://127.0.0.1:8000/api/update-course-details';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "user@gmail.com:user@123");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$obj['bdata'] = json_decode($response);
		// echo "<pre>";print_r($obj);exit;
		// $this->session->set_flashdata('flash_message', 'Course updated successfully');
		$this->load->view('course_update_view',$obj);

	}	
	public function course_update()
	{
		extract($_POST);
		$data = [
		'id'=>$courseid,
		'title'=>$title,
		'description'=>$description,
		'instructor'=>$instructor,
		'duration'=>$duration,
		];
		
		// print_r($data);exit;
		$url = 'http://127.0.0.1:8000/api/update-course';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "user@gmail.com:user@123");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$obj['bdata'] = json_decode($response);
		// echo "<pre>";print_r($obj['bdata']);exit;
		$this->session->set_flashdata('flash_message', 'Course updated successfully');
		redirect(site_url().'courses-list');

	}	
	public function deleteCourse($id)
	{
		$url = 'http://127.0.0.1:8000/api/delete-course?id='.$id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "user@gmail.com:user@123");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$obj['bdata'] = json_decode($response);
		$this->session->set_flashdata('flash_message', 'Course deleted successfully');
		redirect(site_url().'courses-list');

	}	
	
}
