@extends(($user->role_id == 3 ? "layouts.instructor" : "layouts.admin" ));


@section('content')

<reading-component></reading-component>

@endsection
