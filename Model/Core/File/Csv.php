<?php 
/**
 * 
 */
class Model_Core_File_Csv
{
	protected $fileName = null;
	protected $path = null;
	protected $file = null;
	protected $handler = null;

	public function get()
	{
		$this->open();
		$keys = null;
		while ($row = fgetcsv($this->getHandler())) {
			if (!$keys) {
				$keys = $row; 
			}else{
				$data[] = array_combine($keys,$row); 
			}
		}
		$this->close();
		return $data;
	}

	public function open()
	{
		$handler = fopen($this->getPath().DS.$this->getFileName(),'r');
		if (!$handler) {
			throw new Exception("File not found!!!", 1);
		}
		$this->setHandler($handler);
		return $this;
	}

	public function close()
	{
		fclose($this->getHandler());
		return $this;
	}

	public function setHandler($handler)
	{
		$this->handler = $handler;
		return $this;
	}

	public function getHandler()
	{
		return $this->handler;
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

	public function setPath($path)
	{
		$this->path = $path;
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