<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            [
                'course' => [
                    'name' => 'The First Step',
                ],
                'books' => [
                    [
                        'name' => 'Book 1',
                        'author' => 'Aden Gingerich',
                        'lessons' => [
                            [
                                'name' => 'JESUS: The Lamb of God',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'JESUS: Holy God',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => 'Book 2',
                        'author' => 'Aden Gingerich',
                        'lessons' => [
                            [
                                'name' => 'JESUS: The Savior',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'JESUS: Living Water',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'JESUS: Divine Physician',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'JESUS: One With The Father',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'JESUS: The Bread Of Life',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'JESUS: Who Is He?',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => 'Book 3',
                        'author' => 'Aden Gingerich',
                        'lessons' => [
                            [
                                'name' => 'JESUS: Sight To The Blind',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'JESUS: The Good Shepherd',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                        ]
                    ],
                ],
            ],
            [
                'course' => [
                    'name' => 'Steppingstones to God',
                ],
                'books' => [
                    [
                        'name' => 'Book 1',
                        'author' => 'Aden Gingerich',
                        'lessons' => [
                            [
                                'name' => 'GOD',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => 'Book 2',
                        'author' => 'Aden Gingerich',
                        'lessons' => [
                            [
                                'name' => 'The Bible',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'The Fall Of Man',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'The Remedy For Sin',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => 'Book 3',
                        'author' => 'Aden Gingerich',
                        'lessons' => [
                            [
                                'name' => 'How to Become a Christian',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'Assurance of Salvation',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'Victory',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'name' => 'Book 4',
                        'author' => 'Aden Gingerich',
                        'lessons' => [
                            [
                                'name' => 'Obedience',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'Christian Growth',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'The Christian Church',
                                'paragraphs' => [
                                    [
                                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in risus mi. Cras nunc dolor, porttitor sit amet dictum eu, eleifend vel felis. Nunc eget pellentesque mauris. Nam sed risus eu elit pulvinar euismod. Mauris non velit nibh. Donec tincidunt sapien dolor, non auctor augue volutpat ac. Phasellus porttitor eleifend enim. Quisque molestie faucibus volutpat. Maecenas imperdiet enim eget nunc malesuada, venenatis rutrum lectus dapibus. Nam accumsan malesuada imperdiet. Nulla vestibulum magna orci, quis fermentum quam elementum molestie. Proin in eros tincidunt, pretium velit et, fringilla purus. Sed id euismod orci, a convallis libero. Nunc felis lectus, vestibulum id lobortis sed, aliquam eu dolor.'
                                    ],
                                    [
                                        'content' => 'Praesent viverra rutrum enim sit amet fringilla. Praesent ut fermentum leo. Sed metus felis, sodales id augue eget, aliquam sodales dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et cursus enim, quis gravida magna. Curabitur quam nisl, maximus in ultrices ut, aliquet interdum nibh. Etiam et luctus tellus. Donec lectus diam, aliquet quis metus ac, mattis congue augue. Mauris laoreet sem mi, a eleifend turpis finibus eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec sed sem lobortis leo laoreet sodales. Nunc non nunc tristique ante sollicitudin vehicula. In suscipit mi at sodales mollis.'
                                    ],
                                    [
                                        'content' => 'Curabitur mattis odio velit, quis ornare libero aliquet eget. Fusce dignissim, orci sit amet tristique tempus, ligula turpis aliquam dolor, nec scelerisque massa sem eget dolor. Donec lacus magna, vehicula eget lorem dapibus, ullamcorper lacinia ex. Etiam efficitur auctor enim, sed commodo risus vulputate vitae. Etiam semper consectetur lacinia. Morbi volutpat nulla est, quis lacinia arcu accumsan commodo. Proin maximus tortor dolor, eu volutpat arcu porta non. Quisque ac leo tortor. Quisque fermentum, dui id euismod malesuada, sapien erat condimentum velit, a lacinia turpis sapien at ante. Nunc vitae elit dolor.'
                                    ],
                                    [
                                        'content' => 'Aliquam ac nulla accumsan, gravida elit quis, accumsan leo. Donec facilisis ante tellus, id ultrices diam ornare sit amet. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sed massa sem. Proin vitae sapien nec dolor cursus viverra. Mauris et rutrum leo. Donec ultricies tempus justo ac dictum. Pellentesque egestas felis nec fringilla elementum. Integer vehicula commodo ex, in iaculis diam suscipit vel. Etiam pharetra interdum luctus. Aliquam purus enim, condimentum quis dignissim nec, tempor at ipsum. Nullam blandit pretium erat, sit amet aliquam lacus tempor sit amet. Sed consequat ligula id cursus aliquam. Fusce sit amet lectus sit amet sem iaculis sodales. Aliquam eget lacus placerat, varius nisi a, ornare risus. Etiam maximus placerat diam cursus venenatis.'
                                    ],
                                ]
                            ],
                        ]
                    ],
                ],
            ],
        ];

        foreach ($courses as $course_data) {
            $course = \App\Models\Course::updateOrCreate(['name' => $course_data['course']['name']]);

            foreach ($course_data['books'] as $book_data) {
                $book = \App\Models\Book::updateOrCreate(['course_id' => $course->id, 'name' => $book_data['name'], 'author' => $book_data['author']]);

                foreach ($book_data['lessons'] as $lesson_data) {
                    $lesson = \App\Models\Lesson::updateOrCreate(['book_id' => $book->id, 'name' => $lesson_data['name']]);

                    foreach ($lesson_data['paragraphs'] as $paragraph_data) {
                        $paragraph = \App\Models\Paragraph::updateOrCreate(['lesson_id' => $lesson->id, 'content' => $paragraph_data['content']]);
                    }
                }
            }
        }
    }
}
