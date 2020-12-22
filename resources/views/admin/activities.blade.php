@extends(($user->role_id == 3 ? "layouts.instructor" : "layouts.admin" ));


@section('content')

<activities-component></activities-component>

@endsection
