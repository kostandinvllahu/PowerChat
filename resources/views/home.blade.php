@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Start of PowerChat Introduction -->
                    <h2>Introducing PowerChat: Connect, Communicate, and Create Connections!</h2>
                    <p>PowerChat is an innovative social media platform designed to bring people closer together. With its user-friendly interface and powerful features, PowerChat offers a seamless experience for connecting with friends, meeting new people, and engaging in meaningful conversations.</p>

                    <p>Creating an account on PowerChat is a breeze, providing you with a personalized space to express yourself and connect with others. Whether you're a social butterfly or looking to expand your social circle, PowerChat is the perfect platform for building and nurturing relationships.</p>

                    <p>Once you've logged in, PowerChat opens up a world of possibilities. You can effortlessly search for people based on their interests, location, or mutual connections. Discover like-minded individuals who share your passions or connect with friends from various walks of life. The choice is yours!</p>

                    <p>With PowerChat's friend request system, you can send requests to connect with individuals who intrigue you. Build a network of friends and expand your social horizons. As your connections grow, so does the potential for exciting conversations and meaningful interactions.</p>

                    <p>PowerChat's messaging feature is the heart of the platform, providing a convenient and secure way to communicate with your friends and new connections. Engage in private conversations, share photos, exchange ideas, or simply have fun chatting away. PowerChat ensures that your conversations remain private and secure, fostering a safe and trustworthy environment for all users.</p>

                    <p>Whether you're seeking new friendships, professional connections, or simply a place to unwind and socialize, PowerChat is the ultimate destination. Join us today and experience the thrill of connecting with people from all walks of life, discovering new perspectives, and forging lasting bonds.</p>

                    <h3>PowerChat: Where Connections Come Alive!</h3>
                    <!-- End of PowerChat Introduction -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
