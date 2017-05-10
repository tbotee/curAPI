<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Buffon
 */

namespace Tbotee\CurAPI; 
 
class CurrencyDb {
    
    
    #region members
    
    public $curlError;
    
    private $hostUrl = 'http://parser.dev/api.php';
    
    private $publicApiKey = '';
    
    /*
     * Default is today. The date of the currencies.
     */
    private $date = array();
    
    /*
     * Default all intitutes will be fateched
     */
    private $institutes = array();
    
    /*
     * Currency types whis you need from the server
     * 
     * Expecrs an array like: EUR, USD, HUF
     */
    private $currencyTypes = array();
    
    #endregion members
    
    function __construct($apiKey) 
    {
        //Todo introduce apiKey login 
        $this->publicApiKey = $apiKey;
    }

    
    /*
     * Set api host url
     */
    function withtUrl()
    {
        $this->hostUrl = $url;
    }
    
    public function getCurrencyTypes()
    {
        $url = $this->hostUrl . '?'
                . 'action=getCurrencyTypes';
        
        $result = $this->getPageContent($url);
        
        if ($this->curlError['http_code'] == 200)
        {
            return $result;
        }
        else
        {
            return array(
                'errorCode'=> 1, 
                'errorText' => 'Api url (' . $this->hostUrl . ' not awailable! Hint: use $currencyDb->withtUrl([changed url]) to thange it.',
                'currencyValues' => array(),
                'curls_http_code' => $this->curlError['http_code']
            );
        }
    }
    
    public function getInstitutes()
    {
        $url = $this->hostUrl . '?'
                . 'action=getIntitutes';
        
        $result = $this->getPageContent($url);
        
        if ($this->curlError['http_code'] == 200)
        {
            return $result;
        }
        else
        {
            return array(
                'errorCode'=> 1, 
                'errorText' => 'Api url (' . $this->hostUrl . ' not awailable! Hint: use $currencyDb->withtUrl([changed url]) to thange it.',
                'currencyValues' => array(),
                'curls_http_code' => $this->curlError['http_code']
            );
        }
    }
    
    public function getCurrencyValues()
    {
        $url = $this->hostUrl . '?'
                . 'action=getCurrencyValues&'
                . 'date=' . urlencode(json_encode($this->date)) . '&'
                . 'currencyTypes=' . urlencode(json_encode($this->currencyTypes)) . '&'
                . 'institutes=' . urlencode(json_encode($this->institutes));
        
        $result = $this->getPageContent($url);
        
        if ($this->curlError['http_code'] == 200)
        {
            return $result;
        }
        else
        {
            return array(
                'errorCode'=> 1, 
                'errorText' => 'Api url (' . $this->hostUrl . ' not awailable! Hint: use $currencyDb->withtUrl([changed url]) to thange it.',
                'currencyValues' => array(),
                'curls_http_code' => $this->curlError['http_code']
            );
        }
    }
    
    /*
     * Set the prefered currency types, if empty all currency types will be fatched from the server
     * 
     * Parameter can be array, or string: EUR, USD, HUF
     * 
     */
    function withCurrencyTypes($array)
    {
        if (is_array($array))
        {
            $this->currencyTypes = $array; 
        } 
        else 
        {
            $this->currencyTypes[] = $array;
        }
        
    }
    
    /*
     * Set the prefered cinstitutes, if empty all currencies from all institutes will be fatched from the server
     * 
     * Parameter can be array, or string: BCR, ING
     * 
     */
    function withInstitutes($array)
    {
        if (is_array($array))
        {
            $this->institutes = $array; 
        } 
        else 
        {
            $this->institutes[] = $array;
        }
        
    }
    
    /*
     * Expects date array in format "Y-m-d"
     * 
     * Sets the date array. If left empty, currency values for today will be fatched
     * 
     * Return nothing
     */
    function withDates($dateArray)
    {
        if (is_array($dateArray))
        {
            $this->date = $dateArray;
        }
        else 
        {
            $this->date[] = $dateArray;
        }
            
    }
    
    public function getPageContent($url)
    {
	$userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
	    CURLOPT_USERAGENT => $userAgent,
	    CURLOPT_FOLLOWLOCATION => true,
	    CURLOPT_HEADER => false, 
        ));
        $resp = curl_exec($curl);
        $this->curlError = curl_getinfo($curl);
        curl_close($curl);
        return $resp;
    }
    
    
}
