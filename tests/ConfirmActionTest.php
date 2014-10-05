<?php

use DanHarper\InboxActions\InboxAction;

class ConfirmActionTest extends Test {

    public function testBasicConfirmAction()
    {
        $actual = InboxAction::ConfirmAction('Approve', 'http://acme');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ConfirmAction",
        "name": "Approve",
        "handler": {
            "@type": "HttpActionHandler",
            "method": "http://schema.org/HttpRequestMethod/GET",
            "url": "http://acme"
        }
    }
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

    public function testPostRequest()
    {
        $actual = InboxAction::ConfirmAction('Approve', 'http://acme', 'POST');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "ConfirmAction",
        "name": "Approve",
        "handler": {
            "@type": "HttpActionHandler",
            "method": "http://schema.org/HttpRequestMethod/POST",
            "url": "http://acme"
        }
    }
}
</script>
OUT;

        $this->eq($expected, $actual);
    }

} 