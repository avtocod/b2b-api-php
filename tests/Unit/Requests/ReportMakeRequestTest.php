<?php

declare(strict_types = 1);

namespace Avtocod\B2BApi\Tests\Unit\Requests;

use Avtocod\B2BApi\Tests\AbstractTestCase;
use Avtocod\B2BApi\Requests\ReportMakeRequest;

/**
 * @covers \Avtocod\B2BApi\Requests\ReportMakeRequest
 */
class ReportMakeRequestTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testRequiredProperties(): void
    {
        $request = new ReportMakeRequest(
            $report_type_uid = $this->faker->word,
            $query_type = $this->faker->word,
            $query = $this->faker->word
        );

        $this->assertSame($report_type_uid, $request->getReportTypeUid());
        $this->assertSame($query_type, $request->getBodyObject()->queryType);
        $this->assertSame($query, $request->getBodyObject()->query);
    }

    /**
     * @return void
     */
    public function testSettedOptionalProperties(): void
    {
        $request = new ReportMakeRequest($this->faker->word, $this->faker->word, $this->faker->word);
        $request
            ->setOptions([
                ($key_one = $this->faker->word) => $this->faker->randomDigitNotNull,
                ($key_two = $this->faker->word) => $this->faker->word,
            ])
            ->setForce($is_force = $this->faker->boolean)
            ->setOnUpdateUrl($on_update = $this->faker->url)
            ->setOnCompleteUrl($on_complete = $this->faker->url)
            ->setData($data = $this->faker->words(3))
            ->setIdempotenceKey($idempotence_key = $this->faker->word);

        $body_object = $request->getBodyObject();

        $this->assertSame($idempotence_key, $body_object->idempotenceKey);
        $this->assertSame($on_update, $body_object->options->webhook['on_update']);
        $this->assertSame($on_complete, $body_object->options->webhook['on_complete']);
        $this->assertSame($is_force, $body_object->options->FORCE);
        $this->assertSame($data, (array) $body_object->data);

        $this->assertObjectHasAttribute($key_one, $body_object->options);
        $this->assertObjectHasAttribute($key_two, $body_object->options);
    }

    /**
     * @return void
     */
    public function testNotSettedOptionalProperties(): void
    {
        $request = new ReportMakeRequest($this->faker->word, $this->faker->word, $this->faker->word);

        $body_object = $request->getBodyObject();

        $this->assertObjectHasAttribute('FORCE', $body_object->options);
        $this->assertObjectNotHasAttribute('on_update', $body_object->options);
        $this->assertObjectNotHasAttribute('on_complete', $body_object->options);
        $this->assertObjectNotHasAttribute('data', $body_object);
    }
}
