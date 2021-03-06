@extends('layouts.admin-master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('src/css/modal.css') }}">
@endsection

@section('content')
    <div class="container">
        @include('includes.info-box')
        <div class="card">
            <header>
                <nav>
                    <ul>
                        <li><a href="{{ route('admin.blog.create_post') }}" class="btn">New Post</a></li>
                        <li><a href="{{ route('admin.blog.index') }}" class="btn">Show all Post</a></li>
                    </ul>
                </nav>
            </header>
            <section>
                <ul>
                    @if(count($posts) == 0)
                        <li>No posts</li>
                    @else
                        @foreach($posts as $post)
                        <li>
                            <article>
                                <div class="post-info">
                                    <h3>{{ $post->title }}</h3>
                                    <span class="info">{{ $post->author }} | {{ $post->created_at }}</span>
                                </div>
                                <div class="edit">
                                    <nav>
                                        <ul>
                                            <li><a href="{{ route('admin.blog.single',['post_id' => $post->id,'end' => 'admin']) }}">View Post</a></li>
                                            <li><a href="{{ route('admin.blog.post.edit',['post_id' => $post->id]) }}">Edit</a></li>
                                            <li><a href="{{ route('admin.blog.post.delete',['post_id' => $post->id]) }}" class="danger">Delete</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </article>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </section>
        </div>

          <div class="card">
            <header>
                <nav>
                    <ul>
                        <li><a href="" class="btn">Show all Message</a></li>
                    </ul>
                </nav>
            </header>
            <section>
                <ul>
                    @if (count($contact_messages) == 0)
                        <li>No Messages</li>
                    @endif
                    @foreach($contact_messages as $contact_message)
                          <li>
                                <article data-message="{{$contact_message->body}}" data-id="{{$contact_message->id}}">
                                    <div class="message-info">
                                        <h3>{{ $contact_message->subject }}</h3>
                                        <span class="info">Sender:{{$contact_message->sender}} | {{$contact_message->created_at}}</span>
                                    </div>
                                    <div class="edit">
                                        <nav>
                                            <ul>
                                                <li><a href="">View</a></li>
                                                <li><a href="" class="danger">Delete</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </article>
                            </li>
                    @endforeach
                  
                </ul>
            </section>
        </div>
    </div>
    <div class="modal" id="contact-message-info">
        <button class="btn" id="modal-close">Close</button>
    </div>
@endsection

@section('scripts')
    <script>
        var token = "{{ csrf_token() }}";
    </script>
    <script src="{{ URL::to('src/js/modal.js') }}"></script>
    <script src="{{ URL::to('src/js/contact-message.js') }}"></script>
@endsection
