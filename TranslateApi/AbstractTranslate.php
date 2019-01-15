<?php
    /**
     * Created by PhpStorm.
     * User: Vieraw
     * Date: 27.04.2018
     * Time: 10:05
     */
    namespace TranslateApi;

    /**
     * Class AbstractTranslate
     * @package TranslateApi
     */
    abstract class AbstractTranslate
    {
        protected $url;
        protected $header = [
            'Content-type: application/x-www-form-urlencoded'
        ];
        protected $verifyPeer = true;
        protected $verifyPeerName = true;
        protected $allowSelfSigned = false;
        protected $proxy = '';
        protected $request_fulluri = false;

        /**
         * AbstractTranslate constructor.
         * @param array $config
         * @throws TranslateException
         */
        public function __construct (array $config = array())
        {
            foreach ($config as $name => $value)
            {
                if (property_exists($this, $name))
                {
                    $this->{$name} = \is_array($this->{$name}) ? \array_merge($this->{$name}, (array)$value) : $value;
                }
            }
            if ($this->url === null)
            {
                throw new TranslateException('Url can not be Null');
            }
        }

        /**
         * @param string $from
         * @param string $to
         * @param string $subject
         * @return bool|string
         * @throws TranslateException
         */
        protected function sendRequest (string $from, string $to, string $subject)
        {
            $result = $this->prepare($from, $to, $subject);

            $context = stream_context_create(
                array(
                    'http' =>
                        array(
                            'method'  => 'POST',
                            'header'  => $this->header,
                            'user_agent' => 'AndroidTranslate/5.3.0.RC02.130475354-53000263 5.1 phone TRANSLATE_OPM5_TEST_1',
                            'proxy' => $this->proxy,
                            'request_fulluri' => $this->request_fulluri,
                            'content' => $result
                        ),
                    'ssl' =>
                        array(
                            'verify_peer' => $this->verifyPeer,
                            'verify_peer_name' => $this->verifyPeerName,
                            'allow_self_signed' => $this->allowSelfSigned
                        ),
                ));

            $result = file_get_contents($this->url, false, $context);
            if ($result === false)
            {
                throw new TranslateException('An error occurred while running the query.');
            }

            return $result;
        }

        /**
         * @param string $from
         * @param string $to
         * @param string $subject
         * @return string
         */
        abstract protected function prepare(string $from, string $to, string $subject) : string;

        /**
         * @param string $subject
         * @param string $to
         * @param string $from
         * @return string
         */
        abstract public function translate (string $subject,  string $to, string $from = 'auto') : string;

        /**
         * @param string $subject
         * @param string $to
         * @param string $from
         * @return string
         */
        abstract public function translit (string $subject,  string $to, string $from = 'auto') : string;
    }