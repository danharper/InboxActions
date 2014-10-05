<?php

use DanHarper\InboxActions\InboxAction;

class SaveActionTest extends Test {

    public function testBasicConfirmAction()
    {
        $actual = InboxAction::SaveAction('Approve', 'http://acme');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "SaveAction",
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
        $actual = InboxAction::SaveAction('Approve', 'http://acme', 'POST');

        $expected = <<<OUT
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "EmailMessage",
    "action": {
        "@type": "SaveAction",
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