<?php

/**
 * This file is part of the Zanra Framework package.
 *
 * (c) v2ay <v2ay.hub@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace V2ay\Slim\Service\Mailer;

class SwiftMailer
{
	private $mailer;
	private $message;

	public function __Construct(array $parameters = array())
	{
    $defaultParameters = array(
      'host' => null, 
      'port' => null, 
      'username' => null, 
      'password' => null, 
      'enctype' => null
    );
    
		$parameters = array_merge($defaultParameters, $parameters);

		$transport = new \Swift_SmtpTransport($parameters['smtp'], $parameters['port'], $parameters['enctype']);
		$transport->setUsername($parameters['username']);
		$transport->setPassword($parameters['password']);
    
		$opt['ssl']['verify_peer'] = false;
		$opt['ssl']['verify_peer_name'] = false;
		$transport->setStreamOptions($opt);

		$this->mailer = new \Swift_Mailer($transport);
	}

	public function message($subject = "", $body = null, $type = "text/plain", $encoding = null, $charset = null)
	{
		$this->message = new \Swift_Message($subject, $body, $type, $encoding, $charset);
		return $this->message;
	}

	public function attach($path, $filename)
	{
		$this->message->attach(
			\Swift_Attachment::fromPath($path)->setFilename($filename)
		);

		return $this->message;
	}

	public function send()
	{
		return $this->mailer->send($this->message);
	}
}