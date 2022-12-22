<?php
namespace Onetech\EasyLazada;

use Onetech\EasyLazada\Exception\InvalidArgumentException;

/**
 * Class Marketplace
 * @package Onetech\EasyLazada
 * @method static VN()
 * @method static SG()
 * @method static PH()
 * @method static MY()
 * @method static TH()
 * @method static ID()
 */
final class Marketplace
{
    private static array $countryMap = [
        'VN' => [
            'name' => 'Vietnam',
            'url' => 'https://api.lazada.vn/rest/'
        ],
        'SG' => [
            'name' => 'Singapore',
            'url' => 'https://api.lazada.sg/rest/'
        ],
        'PH' => [
            'name' => 'Philippines',
            'url' => 'https://api.lazada.com.ph/rest/'
        ],
        'MY' => [
            'name' => 'Malaysia',
            'url' => 'https://api.lazada.com.my/rest/'
        ],
        'TH' => [
            'name' => 'Thailand',
            'url' => 'https://api.lazada.co.th/rest/'
        ],
        'ID' => [
            'name' => 'Indonesia',
            'url' => 'https://api.lazada.co.id/rest/'
        ],
    ];

    private string $countryCode;

    private string $name;

    private string $url;

    private function __construct(string $countryCode, string $name, string $url)
    {
        $this->countryCode = $countryCode;
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @param string $countryCode
     * @throws InvalidArgumentException
     * @return mixed
     */
    public static function fromCountry(string $countryCode): self
    {
        $countryCode = strtoupper($countryCode);

        try {
            return self::$countryCode();
        } catch (\BadMethodCallException $e) {
            throw new InvalidArgumentException("Unexpected country code {$countryCode}");
        }
    }

    /**
     * @return array<self>
     */
    public static function all(): array
    {
        $marketplaces = [];

        foreach (self::$countryMap as $countryCode => $item) {
            $marketplaces[] = new self($countryCode, $item['name'], $item['url']);
        }

        return $marketplaces;
    }

    public static function __callStatic(string $country, array $parameters)
    {
        if (! \array_key_exists($country, self::$countryMap)) {
            throw new \BadMethodCallException('Call to undefined method ' . self::class . '::' . $country . '()');
        }

        $map = self::$countryMap[$country];

        return new self($country, $map['name'], $map['url']);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function countryCode(): string
    {
        return $this->countryCode;
    }
}