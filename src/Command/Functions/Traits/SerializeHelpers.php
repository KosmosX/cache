<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 13/12/18
 * Time: 22.26
 */

namespace Kosmosx\Cache\Command\Functions\Traits;

use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;

trait SerializeHelpers
{
    private $serializer;

    private $autodetect = true;

    public function setAutodetect(bool $autodetect): self
    {
        $this->autodetect = $autodetect;
        return $this;
    }

    public function getAutodetect()
    {
        return $this->autodetect;
    }

    /** Function in beta
     *
     * @return null|string
     * protected function _createdAt(): ?string
     * {
     *      $arg = $this->serializer->getArgs('created_at');
     *
     *      if (array_key_exists('created_ad', $arg))
     *          return $arg['created_at'];
     *
     *      return null;
     * }
	 *
	 * @param $rawData
	 * @param SerializerInterface|null $serializer
	 * @return mixed
	 */
    protected function _unserializeData($rawData, ?SerializerInterface $serializer = null)
    {
        if ($serializer instanceof SerializerInterface)
            $this->setSerializer($serializer, $rawData);
        elseif (true === $this->autodetect)
            $this->setSerializerAutodetect($rawData);
        else
			$this->serializer->setRawData($rawData);

		return $this->serializer->get();
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    protected function _serializeData($data): ?string
    {
        $rawData = $this->serializer->make($data);
        return $rawData;
    }

    /**
     * autodetect serializer from cached data
	 *
	 * @param null $rawData
	 */
    public function setSerializerAutodetect($rawData = null): void
    {
        $args = $this->serializer->getArgs('serializer');

        if (array_key_exists('serializer', $args) && $args['serializer'] !== get_class($this->serializer)){
			try {
				if((new $args['serializer']) instanceof SerializerInterface)
					$this->serializer = new $args['serializer']($rawData);
			} catch (\Exception $e) {
				throw new $e;
			}
		}
    }

    /**
     * Private function to _set Serializer
	 *
	 * @param SerializerInterface $serializer
	 * @param null $rawData
	 * @return SerializeHelpers
	 */
    public function setSerializer(SerializerInterface $serializer, $rawData = null): self
    {
        $this->serializer = $serializer;

        if (null != $rawData)
            $this->serializer->setRawData($rawData);

        return $this;
    }
}