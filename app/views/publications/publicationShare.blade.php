<h1>{{ Lang::get('publication.titles.social') }}</h1>
<div>
    <!-- facebook -->
    <a href="https://www.facebook.com/sharer/sharer.php?u={{{url($publication['id'])}}}"
    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');shareFacebook({{{$publication['id']}}},'{{{$publication['title']}}}');return false;"
    target="_blank" title="Share on Facebook">
        <span class="sprite-social social-facebook" alt="Share on Facebook"></span>
    </a>
    <!-- google+ -->
    <a href="https://plus.google.com/share?url={{{url($publication['id'])}}}" onclick="javascript:window.open(this.href,
    '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');shareGoogle({{{$publication['id']}}},'{{{$publication['title']}}}');return false;" target="_blank" title="Share on Google+">
        <span class="sprite-social social-google" alt="Share on Google+"></span>
    </a>
    <!-- twitter -->
    <a href="https://twitter.com/share?url={{{url($publication['id'])}}}&hashtags=SPOTALERT&text={{{$publication['title']}}}"
    onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');shareTwitter({{{$publication['id']}}},'{{{$publication['title']}}}');return false;"
    target="_blank" title="Share on Twitter">
        <span class="sprite-social social-twitter" alt="Share on Twitter"></span>
    </a>
    <!-- linkedIn -->
    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{{url($publication['id'])}}}&title={{{$publication['title']}}}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');shareLinkdIn({{{$publication['id']}}},'{{{$publication['title']}}}');return false;"
    target="_blank" title="Share on LinkdIn">
        <span class="sprite-social social-linkdin" alt="Share on LinkdIn"></span>
    </a>
</div>