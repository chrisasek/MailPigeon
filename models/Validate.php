<?php
class Validate
{
	private $_passed = false,
		$_errors = array(),
		$db = null;

	public function __construct()
	{
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array())
	{
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = isset($source[$item]) ? trim($source[$item]) : null;
				$item = Helpers::escape($item);
				if ($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required");
				} else if (!empty($value)) {
					switch ($rule) {
						case 'min':
							if (strlen($value) < $rule_value) {
								$this->addError("{$item} must be a minimun of {$rule_value} Characters");
							}
							break;
						case 'max':
							if (strlen($value) > $rule_value) {
								$this->addError("{$item} must be a maximum of {$rule_value} Characters");
							}
							break;
						case 'matches':
							if ($value != $source[$rule_value]) {
								$this->addError("{$rule_value} must match {$item}");
							}
							break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if ($check && $check->count()) {
								$this->addError("{$item} already exists.");
							}
							break;
						case 'lessorequal':
							if (strtotime($value) && strtotime($source[$rule_value])) {
								if (strtotime($value) > strtotime($source[$rule_value])) {
									$this->addError("{$item} must be less than or equals {$rule_value}");
								}
							} else {
								if ($value > $source[$rule_value]) {
									$this->addError("{$item} must be less than or equals {$rule_value}");
								}
							}

							break;
						case 'greaterorequal':
							if (strtotime($value) && strtotime($source[$rule_value])) {
								if (strtotime($value) < strtotime($source[$rule_value])) {
									$this->addError("{$item} must be greater than or equals {$rule_value}");
								}
							} else {
								if ($value < $source[$rule_value]) {
									$this->addError("{$item} must be greater than or equals {$rule_value}");
								}
							}
							break;
						case 'valid_email':
							$value = filter_var($value, FILTER_SANITIZE_EMAIL);
							if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$this->addError("{$item} is not a valid email address.");
							}
							break;
						case 'valid_number':
							if (!is_numeric($value) && !ctype_digit($value)) {
								$this->addError("{$item} is not a valid number");
							}
							break;
						case 'positiveint':
							if (is_numeric($value) && !(intval($value) >= 0)) {
								$this->addError("{$item} has to be positive or zero");
							}
							break;
						case 'lettersonly':
							$value = preg_replace('/\s+/', '', $value);
							if (!ctype_alpha($value)) {
								$this->addError("{$item} must be letters only");
							}
							break;
						case 'uppercase':
							$value = str_replace('_', '', $value);
							if (!ctype_upper($value)) {
								$this->addError("{$item} must be a valid name. (upper cases)");
							}
							break;
						case 'set_uppercase':
							if ($rule_value) {
								$source[$item] = strtoupper($source[$item]);
							}
							break;
						case 'set_lowercase':
							if ($rule_value) {
								$source[$item] = strtolower($source[$item]);
								// print_r($source[$item]); die;
							}
							break;
						case 'not_default':
							if ($value === 'default') {
								$this->addError("{$item} cannot be default, please select {$item}");
							}
							break;
						case 'valid_url':
							if (!(filter_var($value, FILTER_VALIDATE_URL))) {
								$this->addError("{$item} must be a valid link");
							}
							break;
						case 'valid_date':
							$vals = str_replace('/', '-', $value);
							$vals = strtotime($value);
							$vals = date('m-d-Y', $vals);
							$vals = explode('-', $vals);
							if (!checkdate($vals[0], $vals[1], $vals[2])) {
								$this->addError("{$item} is an invalid date, please follow given format yyyy/mm/dd eg. 1960-12-31");
							}
							break;
						case 'maximum':
							if (((int) ($value)) > $rule_value) {
								$this->addError("{$item} figures too high! We are sorry.");
							}
							break;
						case 'minimum':
							if (((int) ($value)) < $rule_value) {
								$this->addError("{$item} figures too low! We are sorry.");
							}
							break;
					}
				}
			}
		}
		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	// validate files
	public function checkFiles($files = array(), $type, $total, $adtype = null)
	{
		if (!empty($files)) {
			// switch type
			switch ($type) {
				case "resource":
					$vext = "rar,zip,pdf,jpg,jpeg,png,gif,x-png,pjpeg,docx,txt,";
					$this->addError("Sorry, invalid file extension. See allowed Ext. " . $vext);
					if (count($files['name']) == 1) {
						foreach ($files['name'] as $index => $file) {
							$fileName = $files['name'][$index];
							// Upload error?
							if ($files['error'][$index] !== 0) {
								$this->addError($this->_uploadErr[$files['error'][$index]]);
							}
							// Check file size
							if (ceil(($files['size'][$index] / 1000) / 1000) > 7) {
								$size = ceil(($files['size'][$index] / 1000) / 1000) . "MB";
								$this->addError("Your audio {$fileName} with size of {$size} is too large. Must be less than or equals 7MB");
							}
							// File type 
							$extensions = explode(',', $vext);
							$imageFileType = explode('.', $files['name'][$index]);
							if (!in_array(end($imageFileType), $extensions)) {
								$this->addError("Sorry, invalid file extension. See allowed Ext. " . $vext);
							}
							// Finally check error existence
							if (empty($this->_errors)) {
								$this->_passed = true;
							}
						}
					} else {
						$this->addError("Sorry, maximum number of files exceeded! 1 audio at a time");
					}
					break;
				case 'file':
					if (count($files['name']) <= $total) {
						foreach ($files['name'] as $index => $file) {
							$fileName = $files['name'][$index];
							// Upload error?
							if ($files['error'][$index] !== 0) {
								$this->addError($this->_uploadErr[$files['error'][$index]]);
							}
							// Actual image or fake
							if (!getimagesize($files["tmp_name"][$index])) {
								$this->addError("File {$fileName} is not an image");
							}
							if ($adtype) {
								list($w, $h) = getimagesize($files["tmp_name"][$index]);
								switch ($adtype) {
									case 'type1':
										if ($w != 400 || $h != 400) {
											$this->addError("File {$fileName} has no required dimensions it should be 400x400");
										}
										break;
									case 'type2':
										if ($w != 1200 || $h != 200) {
											$this->addError("File {$fileName} has no required dimensions it should be 1200x200");
										}
										break;
								}
							}
							// Check file size
							if (ceil($files['size'][$index] / 1024) > 2048) {
								$size = ceil($files['size'][$index] / 1024) . "KB";
								$this->addError("Your file {$fileName} with size of {$size} is too large. Must be less than or equals 2048KB (2MB)");
							}
							// File type 
							$extensions = explode(',', 'jpg,jpeg,png,gif,x-png,pjpeg');
							$imageFileType = explode('.', $files['name'][$index]);
							if (!in_array(end($imageFileType), $extensions)) {
								$this->addError("Sorry, only JPG, JPEG, PNG, PJPEG, X-PNG & GIF files are allowed.");
							}
							// Finally check error existence
							if (empty($this->_errors)) {
								$this->_passed = true;
							}
						}
					} else {
						$this->addError("Sorry, maximum number of files exceeded! 5 Maximum");
					}
					break;
				case 'video':
					if (count($files['name']) == 1) {
						foreach ($files['name'] as $index => $file) {
							$fileName = $files['name'][$index];
							// Upload error?
							if ($files['error'][$index] !== 0) {
								$this->addError($this->_uploadErr[$files['error'][$index]]);
							}
							// Check file size
							if (ceil(($files['size'][$index] / 1000) / 1000) > 7) {
								$size = ceil(($files['size'][$index] / 1000) / 1000) . "MB";
								$this->addError("Your video {$fileName} with size of {$size} is too large. Must be less than or equals 7MB");
							}
							// File type 
							$extensions = explode(',', 'mp4');
							$imageFileType = explode('.', $files['name'][$index]);
							if (!in_array(end($imageFileType), $extensions)) {
								$this->addError("Sorry, invlid video extension. See allowed Ext. " . 'mp4');
							}
							// Finally check error existence
							if (empty($this->_errors)) {
								$this->_passed = true;
							}
						}
					} else {
						$this->addError("Sorry, maximum number of files exceeded! 1 video at a time");
					}
					break;
			}
		} else {
			$this->addError("Sorry, empty files not allowed");
		}
		return $this;
	} //start

	// check files upload and validatio


	// previewing images
	public function imagePreviewSize($image, $path, $filename, $h, $w)
	{
		$handle = new upload($image);
		if ($handle->uploaded) {
			$handle->file_new_name_body   = $filename;
			//$handle->file_force_extension = null;
			$handle->image_resize         = true;
			$handle->image_y              = $h;
			$handle->image_x              = $w;
			$handle->image_ratio_crop = true;
			$handle->process($path);
			if ($handle->processed) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	private function addError($error)
	{
		$this->_errors[] = $error;
	}
	public function errors()
	{
		return $this->_errors;
	}
	public function passed()
	{
		return $this->_passed;
	}
}
