<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lessons extends CI_Controller {

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
	public function lessons()
	{
		$ch = curl_init('http://127.0.0.1:8000/api/courses');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
		$response = curl_exec($ch);
		curl_close($ch);
		$res['courses'] = json_decode($response);
		$ch = curl_init('http://127.0.0.1:8000/api/lessons');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
		$response = curl_exec($ch);
		curl_close($ch);
		$res['ldata'] = json_decode($response);
		$this->load->view('lessons_dashboard',$res);
	}
	public function course_lessons($courseid)
	{
		$data = ['id'=>$courseid];
		$ch = curl_init('http://127.0.0.1:8000/api/course-lessons?id='.$courseid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
		$response = curl_exec($ch);
		curl_close($ch);
		$res['cdata'] = json_decode($response);
		$this->load->view('lessons_dashboard',$res);
	}
	public function createLession(){
		extract($_POST);
		$data = [
		'title' => $title,
		'content' => $content,
		'course_id' => $course_id,
		];
			$ch = curl_init('http://127.0.0.1:8000/api/create-lesson');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
			$response = curl_exec($ch);
			curl_close($ch);
			$obj['bdata'] = json_decode($response);
			if(isset($obj['data']->id))
			{	
				$this->session->set_flashdata('flash_message', 'Lesson created successfully');
			}
			else
			{
				$this->session->set_flashdata('flash_message', 'Failed Lesson creation successfully');
			}
		redirect(site_url().'lessons-list');
	}
	public function lesson_update_view($id)
	{
		$data = ['id'=>$id];
		
		$ch = curl_init('http://127.0.0.1:8000/api/courses');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
		$response = curl_exec($ch);
		curl_close($ch);
		$res['cdata'] = json_decode($response);
		$url = 'http://127.0.0.1:8000/api/update-lesson-details';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "user@gmail.com:user@123");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$res['ldata'] = json_decode($response);
		$this->load->view('lesson_update_view',$res);
	}	
	public function lesson_update()
	{
		extract($_POST);
		$data = [
		'id'=>$id,
		'title'=>$title,
		'content'=>$content,
		'course_id'=>$course_id,
		];		
		$url = 'http://127.0.0.1:8000/api/update-lesson';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$obj['bdata'] = json_decode($response);
		$this->session->set_flashdata('flash_message', 'Lesson updated successfully');
		redirect(site_url().'lessons-list');
	}	
	public function deleteLesson($id)
	{
		$url = 'http://127.0.0.1:8000/api/delete-lesson?id='.$id;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->session->userdata('email').":".$this->session->userdata('password'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$obj['bdata'] = json_decode($response);
		$this->session->set_flashdata('flash_message', 'Course deleted successfully');
		redirect(site_url().'lessons-list');
	}	
}
