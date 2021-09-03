<?php
/**
 * @author lin <465382251@qq.com>
 * */

namespace Lin\Exchange;

use Lin\Exchange\Api\Account;
use Lin\Exchange\Api\Trader;
use Lin\Exchange\Api\Market;

class Exchanges
{
    protected $exchange='';
    protected $key='';
    protected $secret='';
    protected $extra='';
    protected $host='';

    protected $platform='';
    protected $version='';

    protected $acount;
    protected $market;
    protected $trader;

    protected $options=[];


    function __construct(string $exchange,string $key='',string $secret='',string $extra='',string $host=''){
        $this->exchange=$exchange;
        $this->key=$key;
        $this->secret=$secret;
        $this->extra=$extra;
        $this->host=$host;

        if(stripos($extra,'http')===0) {
            $this->host=$extra;
            $this->extra='';
        }
    }

    /**
     *
     * */
    function account(){
        $this->acount=new Account($this->exchange,$this->key,$this->secret,$this->extra,$this->host);
        $this->acount->setPlatform($this->platform)->setVersion($this->version);
        $this->acount->setOptions($this->options);
        return $this->acount;
    }

    /**
    *
    * */
    function market(){
        $this->market=new Market($this->exchange,$this->key,$this->secret,$this->extra,$this->host);
        $this->market->setPlatform($this->platform)->setVersion($this->version);
        $this->market->setOptions($this->options);
        return $this->market;
    }

    /**
    *
    * */
    function trader(){
        $this->trader=new Trader($this->exchange,$this->key,$this->secret,$this->extra,$this->host);
        $this->trader->setPlatform($this->platform)->setVersion($this->version);
        $this->trader->setOptions($this->options);
        return $this->trader;
    }

    /**
     * Returns the underlying instance object
     * */
    public function getPlatform(string $type=''){
        if($this->trader!==null) return $this->trader->getPlatform($type);
        if($this->market!==null) return $this->market->getPlatform($type);
        if($this->acount!==null) return $this->acount->getPlatform($type);

        return $this->trader()->getPlatform($type);
    }

    /**
    Set exchange transaction category, default "spot" transaction. Other options "spot" "margin" "future" "swap"
     */
    public function setPlatform(string $platform=''){
        $this->platform=$platform;
        return $this;
    }

    /**
    Set exchange API interface version. for example "v1" "v3" "v5"
     */
    public function setVersion(string $version=''){
        $this->version=$version;
        return $this;
    }

    /**
     * Support for more request Settings
     * */
    function setOptions(array $options=[]){
        $this->options=$options;
    }
}
