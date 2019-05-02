<?php
try {
	
	/* FILES */
	\File::delete(app_path('Http/Controllers/Post/CreateController.php'));
	\File::delete(app_path('Http/Controllers/Post/EditController.php'));
	\File::delete(app_path('Http/Controllers/Post/PaymentController.php'));
	\File::delete(app_path('Http/Controllers/Post/PhotoController.php'));
	
	\File::delete(app_path('Http/Controllers/Post/Traits/AutoRegistrationTrait.php'));
	\File::delete(app_path('Http/Controllers/Post/Traits/EditTrait.php'));
	\File::delete(app_path('Http/Controllers/Post/Traits/PaymentTrait.php'));
	
	\File::delete(base_path('resources/views/post/create.blade.php'));
	\File::delete(base_path('resources/views/post/edit.blade.php'));
	\File::delete(base_path('resources/views/post/finish.blade.php'));
	\File::delete(base_path('resources/views/post/packages.blade.php'));
	\File::delete(base_path('resources/views/post/photos.blade.php'));
	
	\File::delete(base_path('resources/views/post/inc/wizard.blade.php'));
	
} catch (\Exception $e) {}
