<?php

namespace AGmakonts\Hydrator;

use Zend\Stdlib\Hydrator\ArraySerializable;

/**
 * Class JsonSerializable
 *
 * @package   AGmakonts\Hydrator
 * @author    Adam Grabek <adam@procreative.eu>
 * @copyright 1985 - 2015 Kelleher, Helmrich and Associates, Inc.
 */
class JsonSerializable extends ArraySerializable
{
    /**
     * @param \JsonSerializable $object
     *
     * @return mixed
     */
    public function extract($object)
    {
        if(FALSE === ($object instanceof \JsonSerializable)) {
            throw new \BadMethodCallException('Object need to be JsonSerializable instance');
        }

        $data = $object->jsonSerialize();
        $filter = $this->getFilter();

        foreach ($data as $name => $value) {
            if (!$filter->filter($name)) {
                unset($data[$name]);
                continue;
            }
            $extractedName = $this->extractName($name, $object);
            if ($extractedName !== $name) {
                unset($data[$name]);
                $name = $extractedName;
            }
            $data[$name] = $this->extractValue($name, $value, $object);
        }

        return $data;
    }
}