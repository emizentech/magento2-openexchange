<?php
namespace Emizentech\OpenExchange\Model\Currency\Import;

/**
 * Currency rate import model (From www.webservicex.net)
 */
class OpenExchangeRates extends \Magento\Directory\Model\Currency\Import\AbstractImport
{
    /**
     * Currency converter url
     */
    // @codingStandardsIgnoreStart
    const CURRENCY_CONVERTER_URL = 'https://openexchangerates.org/api/latest.json?app_id={{APP_ID}}&base={{CURRENCY_FROM}}';
    // @codingStandardsIgnoreEnd

    /**
     * Core scope config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

	public $directory_list;
    /**
     * @param \Magento\Directory\Model\CurrencyFactory $currencyFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list
    ) {
        parent::__construct($currencyFactory);
        $this->scopeConfig = $scopeConfig;
        $this->directory_list = $directory_list;  
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param int $retry
     * @return float|null
     */
    protected function _convert($currencyFrom, $currencyTo, $retry = 0)
    {
    	$appID = $this->scopeConfig->getValue(
                        'currency/openexchange/app_id',
                        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                    );
        $url = str_replace('{{CURRENCY_FROM}}', $currencyFrom, self::CURRENCY_CONVERTER_URL);
	    $url = str_replace('{{APP_ID}}', $appID, $url);

        try {
        	// check if Latest JSON is already Exist
        	$latestJson = $this->directory_list->getPath('cache') ."/openexchange.json";
        	$renew = true;
        	if(file_exists($latestJson)){
				$latestJsonTimestamp = filectime($latestJson);
				if((time() - $latestJsonTimestamp) > 300) // 300 seconds
				{
					$renew = false;
					$currData = file_get_contents($latestJson);
				}
			}        	
        	if($renew)
        	{
        		
        		$currData = file_get_contents($url);
        		file_put_contents($latestJson , $currData);
        	}
        	
            $allCurrencies = json_decode($currData);
            return (double)$allCurrencies->rates->$currencyTo;
        } catch (\Exception $e) {
            if (!isset($allCurrencies->rates->$currencyTo)) {
                $this->_messages[] = __('Currency rate is not available for %1.', $currencyTo);
            } else {
                $this->_messages[] = __('We can\'t retrieve a rate from %1.', $url);
            }
        }
    }
}
