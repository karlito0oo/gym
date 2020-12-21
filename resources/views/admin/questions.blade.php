@extends(($user->role_id == 3 ? "layouts.instructor" : "layouts.admin" ));

@section('content')

<questions-component user="{{ $user }}"></questions-questions>

@endsection
