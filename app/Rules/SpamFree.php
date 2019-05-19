<?php

namespace App\Rules;

class SpamFree

{
	public function passes($attribute, $value)
	{
		try {
			resolve(Spam::class)->detect($value);	
		} catch (\Exception $e) {
			return false;
		}
	}

	public function message() {

		return "No Spamming, please!";
	}

}