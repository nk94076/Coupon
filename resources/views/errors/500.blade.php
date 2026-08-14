@include('errors.minimal', [
    'code' => 500,
    'title' => 'Something went wrong',
    'message' => "An unexpected error occurred on our end. It's been logged and we'll look into it.",
])
