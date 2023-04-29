<?php 
/**
 * 
 */
class Model_Core_File_Upload
{
	protected $fileName = null;
	protected $path = 'var';
	protected $extensions = [];
	protected $file = null;

	public function upload($name)
	{
		if (!array_key_exists($name, $_FILES)) {
			return false;
		}

		$this->setFile($_FILES[$name]);
		if (!move_uploaded_file($this->file['tmp_name'],$this->getPath().DS.$this->file['name'])) {
			return false;
		}

		return $this;
	}

	public function setFileName($fileName)
	{
		$this->fileName = $fileName;
		return $this;
	}

	public function getFileName()
	{
		return $this->fileName;
	}

	public function setExtensions(array $extensions)
	{
		$this->extensions = $extensions;
		return $this;
	}

	public function getExtensions()
	{
		return $this->extensions;
	}

	public function setPath($subPath)
	{
		if ($subPath) {
			$this->path = Ccc::getBaseDir(DS.$this->getPath().DS.$subPath);
		}
		return $this;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function setFile($file)
	{
		$this->file = $file;
		return $this;
	}

	public function getFile()
	{
		return $this->file;
	}
}