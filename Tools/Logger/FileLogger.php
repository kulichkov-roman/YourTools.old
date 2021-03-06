<?php

namespace YT\Tools\Logger;

use YT\Common\Exception;
use YT\Tools\LoggerInterface;

/**
 * Стандартный логгер, пишущий в файл
 *
 * Class FileLogger
 *
 * @author Roman Kulichkov <roman@kulichkov.pro>
 *
 * @package YT\Tools\Logger
 */
class FileLogger implements LoggerInterface
{
	/**
	 * @var string
	 */
	protected $fileName;

	/**
	 * @param string $fileName
	 *
	 * @throws Exception
	 */
	public function __construct($fileName)
	{
		$this->fileName = $fileName;

		if (!file_exists($this->fileName)) {
			touch($fileName);
		}

		if (!file_exists($this->fileName) || !is_writable($this->fileName)) {
			throw new Exception(sprintf('Can not write to file: %s', $this->fileName));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function log($message)
	{
		file_put_contents(
			$this->fileName,
			sprintf('%s %s' . PHP_EOL, date('Y-m-d H:i:s'), $message),
			FILE_APPEND
		);
	}
}
