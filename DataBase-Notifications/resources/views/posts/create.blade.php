<h1>create New post</h1>

<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Enter Title">
    <input type="text" name="body" placeholder="Enter Body">
    <button type="submit"> Submit</button>
</form>