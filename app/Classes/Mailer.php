<?php
namespace msqueeg\Classes;
/**
 * Mailer class implements PHPMailer
 * https://www.codecourse.com/forum/topics/adding-mail-function-in-slim-3-authentication-series
 */
class Mailer
{
    protected $view;
    
    protected $mailer;

    protected $logger;
    
    public function __construct($view, $mailer, $logger)
    {
        $this->view = $view;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }
    
    public function send($template, $data, $callback)
    {
        $message = new \HRM\Classes\Message($this->mailer);
        
        $message->body($this->view->fetch($template, $data));
        
        call_user_func($callback, $message);
        
        try {
            $this->mailer->send();
        } catch (phpmailerException $e) {
            $this->logger->addInfo($e->errorMessage());
        } catch (Exception $e) {
            $this->logger->addInfo($e->errorMessage());
        }
    }
}