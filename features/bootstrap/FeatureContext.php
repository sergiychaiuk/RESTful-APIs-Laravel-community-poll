<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->bearerToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiNzQ1NTgzZjQ3Y2M1ZTlmMmViNWJkMDVkOGE3MzI0MmUwYjgwNDllYjJhZjgzNzlhMDA1OWUzZjUwN2I2NTcwNzNkZTBjM2Y5Y2FmZmMzNmIiLCJpYXQiOjE2MTc4ODYyMjMuMTQ5NTM5LCJuYmYiOjE2MTc4ODYyMjMuMTQ5NTQ2LCJleHAiOjE2NDk0MjIyMjIuODA1NTQyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.quVRwXtCMXN1NED6FtwjjZJsWjkiRdkB51BNs4sSNSf54A6fEYv-Bn55KPJzN7oGBT-B3V3WHUw4JuLMwSn8A2YPA1M1-kdaYefuUPXDEKrf_wIjcK2AqGKmtqWWHLEny9IQQB_XkGdZYEyKpetQNNlstiTnanCO1mY2zQ1Pes8XV-l1aLqAf2ZeEjfSEQTMYRKAK1hbBkEp45fYJPVsHit5eOUfp5CF6SIs6Png7CR_EUn0qxLzPBFm5FeZflHdQZaOLqKW3NkjLCHqV7MUPk91TXu1LnHsxMP55PZ3ylg0x3yKNbgJq3Nbq-UEpaCCR60jNXGvZcH0We1e_cCMx6eRs69zq3t1KVZG61Eh-C5Tb9Bqoarn_m_LlqQAtRw9FjPCtEpx0Xvpq8RYShIReGROncHvHiBX0eZze44cSfMtfpFpx4ad73OGK4YCebtY_idW5ljAIbV3sptzDV5_2gKaWris-3dCcLRbFIykRJWnWsi336bwP93-uZjyqorO3qtzr6UMDjzZ8KDBZRfU66rilHtRgttuxn9yyJCuqlGxYS0qcLS-Ju_eETDcPlYz8JKlNRQTZlQKZGWBKg3XL6xommNN_vL0xru8WtkFCAZ7oxKn9bjbuDUDJVHsUvS8NVvfCjet53XXVwc0iHYKNiqa7G56zKWi_t8yeviilFI";
    }

    /**
     * @Given I have the payload:
     */
    public function iHaveThePayload(PyStringNode $string)
    {
        $this->payload = $string;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $argument1)
    {
        $client = new GuzzleHttp\Client();
        $this->response = $client->request(
            $httpMethod,
            'http://127.0.0.1:8000' . $argument1,
            [
                'body' => $this->payload,
                'headers' => [
                    "Authorization" => "Bearer {$this->bearerToken}",
                    "Content-Type" => "application/json",
                ],
            ]
        );
        $this->responseBody = $this->response->getBody(true);
    }

    /**
     * @Then /^I get a response$/
     */
    public function iGetAResponse()
    {
        if (empty($this->responseBody)) {
            throw new Exception('Did not get a response from the API');
        }
    }

    /**
     * @Given /^the response is JSON$/
     */
    public function theResponseIsJson()
    {
        $data = json_decode($this->responseBody);

        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->responseBody);
        }
    }

//    /**
//     * @Then the response contains :arg1 records
//     */
//    public function theResponseContainsRecords($arg1)
//    {
//        //throw new PendingException();
//        $data = json_decode($this->responseBody);
//        $count = count($data);
//        return ($count == $arg1);
//    }
    /**
    * @Then the response contains a question
    */
    public function theResponseContainsQuestion()
    {
        //throw new PendingException();
        $data = json_decode($this->responseBody);

        $question = $data[0];

        if (!property_exists($question, 'question')) {
            throw new Exception('This is not a question');
        }
    }

    /**
     * @Then the questions contains a title of :arg1
     */
    public function theQuestionsContainsATitleOf($arg1)
    {
        $data = json_decode($this->responseBody);

        if ($data->title != $arg1) {
            throw new Exception('This title does not match');
        }
    }
}
