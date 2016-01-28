<?php
class Job_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function newJob($name=NULL,$description=NULL,$qualifications=NULL,$skills=NULL){
		$newJob = $this->db->query("INSERT into jobs(name,description,qualifications,skills) VALUES('$name','$description','$qualifications','$skills')");
      return $newJob;
	}
	function updateJob($jobId=NULL,$name=NULL,$description=NULL,$qualifications=NULL,$skills=NULL){
		$result = $this->db->query("UPDATE jobs SET name='$name',description='$description',qualifications='$qualifications',skills='$skills' WHERE id='$jobId'");
		
		return $result;
	}
	
	function get_job_info($jobId){
	$result = $this->db->query("SELECT * FROM JOBS WHERE id='$jobId'");
		return $result;
	}
    function list_of_jobs($status=NULL){
      $joblist = $this->db->query("SELECT * FROM jobs where STATUS='active' LIMIT 9");
      return $joblist;
    }
	
	function deleteJob($id=NULL){
		$result = $this->db->query("DELETE FROM jobs WHERE id='$id'");
		return $result;
	}

    function get_job_applicants($jobId=NULL){
      $applicants = $this->db->query("SELECT users_profile.fullname, users_profile.lastname,users.email,users_profile.contact_no,users_profile.qualification as UQ,users_profile.skills as US,jobs.qualifications as JQ,jobs.skills as JS FROM jobs_info LEFT JOIN users on users.id=jobs_info.applicant_id LEFT JOIN users_profile on users.id=users_profile.id LEFT JOIN jobs on jobs.id=jobs_info.jobs_id
        WHERE jobs_id='{$jobId}'");

      return $applicants;
    }

    function add_applicant($jobId=NULL,$appId=NULL){
      $add_applicant = $this->db->query("INSERT into jobs_info(jobs_id,applicant_id,date_created) VALUES($jobId,$appId,now())");
      return $add_applicant;
    }

    function search_jobs($category=NULL){
      $result = $this->db->query("SELECT * from jobs WHERE MATCH(name,description,qualifications,skills,achievements) AGAINST('{$category}' IN NATURAL LANGUAGE MODE)");

      return $result;
    }

    function match_maker($jobId,$cat=NULL,$string=NULL){
      if($cat == 'Q'){
        $result = $this->db->query("SELECT * FROM jobs WHERE id='{$jobId}' AND qualifications LIKE '%{$string}%'");
      }
      if($cat == 'S'){
        $result = $this->db->query("SELECT * FROM jobs WHERE id='{$jobId}' AND skills LIKE '%{$string}%'");
      }

      return $result;
    }

}
