<x-dashboard title="Dashboard">
    <h1>All Post</h1>
    <div id="postsContainer">
        @foreach($posts as $post)
            @include('components.post', ['post' => $post])
        @endforeach
    </div>
</x-dashboard>