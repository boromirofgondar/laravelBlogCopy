<div class="blog-post">
    <h2 class="blog-post-title">{{ $post->title }}</h2>
    <p class="blog-post-meta">

        {{ $post->user->name }} on
        <!-- Laravel uses Carbon (nesbot/carbon), so we can make nicely formatted dates-->
        {{ $post->created_at->toFormattedDateString() }}
    </p>
    <a href="/posts2/{{ $post->id }}">
        <p>{{ $post->body }}</p>
    </a>
</div><!-- /.blog-post -->