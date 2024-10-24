
<div id="nestedAccordion{{ $loop->iteration }}-sub_{{$count}}" class="accordion">
    <div class="accordion-item">
    <h2 class="accordion-header"
        id="nestedHeading{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}">
        <button class="accordion-button collapsed" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#nestedCollapse{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}"
            aria-expanded="false"
            aria-controls="nestedCollapse{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}">
        <b> Sub Module - </b> &nbsp;{{ $childModule->title }}
        </button>
    </h2>

    <div
        id="nestedCollapse{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}"
        class="accordion-collapse collapse"
        aria-labelledby="nestedHeading{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}"
        data-bs-parent="#nestedAccordion{{ $loop->iteration }}-sub_{{$count}}">
        <div class="accordion-body">
            <div class="accordion"
                id="nestedAccordion{{ $loop->parent->iteration ?? '' }}-sub-module_{{$count}}">

                <a href="{{ route('courseModuleDetail', ['cat_slug' => $data['category']->slug,'course_slug' => $data['course']->slug,'module_slug' => $childModule->slug]) }}">
                <p>{{ $childModule->title }}</p>
                </a>

            @if(isset($childModule->sections) && count($childModule->sections) > 0)
                <div
                    id="nestedAccordion{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}-sections_{{$count}}"
                    class="accordion">
                    @foreach($childModule->sections as $sub_section)
                    <div class="accordion-item">
                        <h2 class="accordion-header"
                            id="nestedHeading{{ $loop->parent->parent->iteration ?? '' }}-{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#nestedCollapse{{ $loop->parent->parent->iteration ?? '' }}-{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}"
                                aria-expanded="false"
                                aria-controls="nestedCollapse{{ $loop->parent->parent->iteration ?? '' }}-{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}">
                            <b> Sub Section - </b>&nbsp; {{ $sub_section->title }}
                            </button>
                        </h2>
                        <div
                            id="nestedCollapse{{ $loop->parent->parent->iteration ?? '' }}-{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}"
                            class="accordion-collapse collapse"
                            aria-labelledby="nestedHeading{{ $loop->parent->parent->iteration ?? '' }}-{{ $loop->parent->iteration ?? '' }}-{{ $loop->iteration }}_{{$count}}"
                            data-bs-parent="#nestedAccordion{{ $loop->iteration }}-{{ $loop->parent->iteration }}-sections">
                            <div class="accordion-body">
                                <div class="accordion"
                                id="nestedAccordion{{ $loop->parent->iteration ?? '' }}-sub-module_{{$count}}">
                                <a href="{{ route('courseModuleSectionDetail', ['cat_slug' => $data['category']->slug,'course_slug' => $data['course']->slug,'module_slug' => $childModule->slug,'section_slug' => $sub_section->slug]) }}">
                                    <p>{{ $sub_section->title }}</p>
                                </a>

                                    @if(isset($sub_section->exercise) && count($sub_section->exercise) > 0)
                                <div
                                    class="accordion"
                                    id="nestedAccordion{{ $loop->iteration }}-{{ $loop->parent->iteration }}-{{ $loop->parent->parent->iteration }}-exercises_{{$count}}">
                                    @foreach($sub_section->exercise as $subModulesectionExercise)
                                    <div class="accordion-item">
                                        <div class="accordion-body"
                                            style="background-color: var(--bs-primary-tint-90); height: 60px; margin-bottom: 1rem;">
                                            <a href="{{ route('courseModuleSectionExcerciseDetail', ['cat_slug' => $data['category']->slug,'course_slug' => $data['course']->slug,'module_slug' => $childModule->slug,'section_slug' => $sub_section->slug,'exercise_slug' => $subModulesectionExercise->slug]) }}">
                                            <p><b>Sub Exercise  - </b>&nbsp;{{ $subModulesectionExercise->title }}</p>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
        @if ($childModule->sub_modules)
            @php $count++  @endphp
            @foreach ($childModule->sub_modules as $childModule)
                @include('courses/child_modules', ['childModule' => $childModule])
            @endforeach
        @endif

    </div>
    </div>
</div>
