# HTTP Replay Test Helper

![Travis Build Status](https://travis-ci.org/Kagency/http-replay.svg "Travis Build Status")

This is a libaray to replay requests and responses in tests. It allows to
filter the responses to remove values, one does not want to assert on.

## Supported Tools

Supported recordings (Reader):

* MitmDump

Supported frameworks (MessageHandler):

* Symfony2

## Workflow

The workflow for using this test helper could be:

First record some HTTP interaction using MitmDump, executing something like this:

    mitmdump -P http://my-website:80/ -p 8080 --anticache -z -w recordFile.tns

The stored file can then be replayed against your application – in my case a
Symfony2 stack – by implementing an integration test like this:

    $messageHandler = new MessageHandler\Symfony2();
    $filter = new ResponseFilter\Dispatcher(array(
        new ResponseFilter\Json(),
        new ResponseFilter\Headers(array(
            'date',
            'etag',
        )),
    ));

    $reader = new Reader\MitmDump($messageHandler);
    $interactions = $reader->readInteractions('recordFile.tns');

    foreach ($interactions as $interaction) {
        $actualResponse = $app->runRequest($interaction->request);

        $this->assertEquals(
            $filter->filterResponse($messageHandler->simplifyResponse($interaction->request, $interaction->response)),
            $filter->filterResponse($messageHandler->simplifyResponse($interaction->request, $actualResponse))
        );
    }

This example only implements a very basic set of response filters. You can
implement conditional response filters, which only act for certain request URLs
and filter, for example, certain JSON properties out of the response.

This example assumes $app is some Symfony2 app, where the method runRequest()
recieves a Request object and returns a Response object.

## Response Filters

A list of currently implemented response filters

### Dispatcher

Takes an array of response filters to apply to the responses. You usually want
to use this one to be able to easily apply a set of filters.

### Json

Tries to parse JSON to make it easier to compare in tests. Also makes other
response filters possible, like the JsonFilter filter.

Takes no arguments.

### JsonFilter

Filters out a defined set of properties from a JSON response. Especially
sensible, if your JSON response contains fields like dates or revisions.

Receives a list of properties to remove as a constructor argument.

### Headers

Implements a blacklist for HTTP headers. Removes those headers from the
response. This is especially useful to remove Date and Etag headers, for
example.

Receives a list of headers to remove as a constructor argument.

### MultipartMixed

Replaces the random boundary string in multipart/mixed responses, to make it
possible to comapre them.

Takes no arguments.

### ConditionalPathRegexp

Takes to arguments:

* Regular expression to match the requested path
* Aggregate filter

Only applies the aggregate filter, if the regular expression matches the
requested path.

## Verify the Build

You can verify the build by running ant:

    ant

This installs all required tools using composer and then runs the tests and
static source code verification. You might also run all the tools manually,
like:

    vendor/bin/phpunit

