<?php

namespace CoreDomain\Model\User;

class UserEmployer
{
	private $user;
	private $employer;

	public function getUser()
	{
		return $this->user;
	}

	public function getEmployer()
	{
		return $this->employer;
	}

	public function updateInfo(User $user, User $employer)
	{
		$this->user = $user;
		$this->employer = $employer;
	}
}