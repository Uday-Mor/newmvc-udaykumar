<?php
/**
 * 
 */
class Model_Core_Pager
{
	public $totalRecords = 0;
	public $currentPage = 0;
	public $totalPages = 0;
	public $firstPage = 1;
	public $previousPage = 0;
	public $nextPage = 0;
	public $recordPerPage = 1;
	public $startLimit = 1;


	public function __construct($totalRecords,$currentPage)
	{
		$this->totalRecords = $totalRecords;
		$this->currentPage = $currentPage;
		$this->calculateParameters();
	}

	public function calculateParameters()
	{
		$this->totalPages = ceil(($this->totalRecords)/($this->recordPerPage));
		if ($this->currentPage > $this->totalPages) {
			$this->currentPage = $this->totalPages;
		}

		if (($this->previousPage = ($this->currentPage)-1) == 0) {
			$this->previousPage = 0;
		}
		
		if (($this->nextPage = ($this->currentPage)+1) > $this->totalPages) {
			$this->nextPage = 0;
		}

		$this->startLimit = (($this->recordPerPage*$this->currentPage)-($this->recordPerPage - 1))-1;
		return $this;
	}

	public function setRecordPerPage($recordPerPage)
	{
		$this->recordPerPage = $recordPerPage;
		return $this;
	}

	public function setTotalRecords($records)
	{
		$this->totalRecords = $records;
		return $this;
	}

	public function setCurrentPage($currentPage)
	{
		$this->currentPage = $currentPage;
		return $this;
	}

	public function getPreviousPage()
	{
		return $this->previousPage;
	}

	public function setPreviousPage($previousPage)
	{
		$this->previousPage = $previousPage;
		return $this;
	}

	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	public function getNextPage()
	{
		return $this->nextPage;
	}

	public function setNextPage($nextPage)
	{
		$this->nextPage = $nextPage;
		return $this;
	}
	
	public function getTotalPages()
	{
		return $this->totalPages;
	}

	public function setTotalPages($totalPages)
	{
		$this->totalPages = $totalPages;
		return $this;
	}
}