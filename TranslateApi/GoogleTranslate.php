<?php
    /**
     * Created by PhpStorm.
     * User: Vieraw
     * Date: 25.04.2018
     * Time: 13:33
     */

    namespace TranslateApi;

    /**
     * Class GoogleTranslate
     * @package TranslateApi
     */
    class GoogleTranslate extends AbstractTranslate
    {
        /**
         * GoogleTranslate constructor.
         * @param array $config
         * @throws TranslateException
         */
        public function __construct (array $config = array ())
        {
            if (!array_key_exists('url', $config))
            {
                $config['url'] = 'https://translate.google.com/translate_a/single?client=at&dt=t&dt=ld&dt=qca&dt=rm&dt=bd&dj=1&hl=es-ES&ie=UTF-8&oe=UTF-8&inputm=2&otf=2&iid=1dd3b944-fa62-4b55-b330-74909a99969e';
            }
            parent::__construct($config);
        }

        /**
         * @param string $from
         * @param string $to
         * @param string $subject
         * @return string
         * @throws TranslateException
         */
        public function translate (string $from, string $to, string $subject) : string
        {
            $request = $this->sendRequest($from, $to, $subject);

            return $this->getSentences('trans', $request);
        }

        /**
         * @param string $from
         * @param string $to
         * @param string $subject
         * @return string
         * @throws TranslateException
         */
        public function translit (string $from, string $to, string $subject) : string
        {
            $request = $this->sendRequest($from, $to, $subject);

            return $this->getSentences('trans', $request);

        }

        /**
         * @param string $from
         * @param string $to
         * @param string $subject
         * @return string
         * @throws TranslateException
         */
        public function prepare (string $from, string $to, string $subject) : string
        {
            $params =
                array (
                    'sl' => urlencode($from),
                    'tl' => urlencode($to),
                    'q' => urlencode($subject)
                );

            if (\strlen($params['q']) >= 5000)
            {
                throw new TranslateException('GoogleTranslate: Maximum number of characters exceeded: 5000');
            }

            $result = '';
            foreach ($params as $key => $value)
            {
                $result .= $key . '=' . $value . '&';
            }

            return $result;
        }

        /**
         * @param string $name
         * @param string $data
         * @return string
         */
        protected function getSentences (string $name, string $data) : string
        {
            $sentences = '';
            $array = json_decode($data, true);

            foreach ($array['sentences'] as $key => $value)
            {
                $sentences .= $value[$name] ?? '';
            }
            return $sentences;
        }

    }
