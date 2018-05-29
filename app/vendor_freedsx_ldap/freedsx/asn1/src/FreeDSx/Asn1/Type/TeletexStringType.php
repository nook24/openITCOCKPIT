<?php
/**
 * This file is part of the FreeDSx ASN1 package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FreeDSx\Asn1\Type;

/**
 * Represents a Teletex String type.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class TeletexStringType extends AbstractStringType
{
    protected $tagNumber = self::TAG_TYPE_TELETEX_STRING;

    protected $isCharRestricted = true;
}
