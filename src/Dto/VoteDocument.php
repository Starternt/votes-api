<?php

namespace App\Dto;

use Reva2\JsonApi\Annotations\ApiDocument;
use Reva2\JsonApi\Annotations\Content;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * JSON API document that contains single vote
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiDocument()
 */
class VoteDocument
{
    /**
     * @var VoteDto
     * @Content(type="App\Dto\VoteDto"
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    public $data;
}
