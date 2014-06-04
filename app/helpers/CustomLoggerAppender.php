<?php
/**
 * Logger customizado para permitir a definicao do local do arquivo de log.
 * @author adolfo
 */
class CustomLoggerAppender extends  LoggerAppenderRollingFile {
	public function setFile($file) {
		$path = LOG_PATH;
		$this->file = $path.$file;
	}
}