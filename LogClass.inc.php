<?php

class FileLogger {
        
    protected $fileHandle = NULL;
    public $dontlog = false;
        
    public function __construct( $logfile ) {
        if ( $this->fileHandle == NULL ) {
            if ( $this->dontlog === false ) $this->openLogFile( $logfile );
        }
    }
        
    public function __destruct() {
        if ( $this->dontlog === false ) $this->closeLogFile();
    }

    public function log( $message, $messagetype, $user_id = null ) {
            /*
            if ( $this->fileHandle == NULL ) {
                throw new FileLoggerException('Logfile is not opened.');
            }
            */
            
            if ( $this->dontlog === false ) $this->writeToLogFile( "[".date( "Y-m-d H:i:s", time())."] - " . $message . " - " . $messagetype );
    }
        
    private function writeToLogFile( $message ) {
        flock( $this->fileHandle, LOCK_EX );
        fwrite( $this->fileHandle, $message.PHP_EOL );
        flock( $this->fileHandle, LOCK_UN );
    }
        
    protected function closeLogFile() {
        if ( $this->fileHandle != NULL ) {
            fclose($this->fileHandle);
            $this->fileHandle = NULL;
        }
    }
        
    public function openLogFile($logFile) {
        $this->closeLogFile();

        if (!is_dir( dirname( $logFile ) ) ) {
            if ( !mkdir( dirname( $logFile ), FileLogger::FILE_CHMOD, true ) ) {
                throw new FileLoggerException( 'Could not find or create directory for log file.' );
            }
        }
        
        if (!$this->fileHandle = fopen( $logFile, 'a+' ) ) {
            throw new FileLoggerException('Could not open file handle.');
        }
    }
    
}

