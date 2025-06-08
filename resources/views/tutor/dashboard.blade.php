@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container py-5 text-light">
    <div class="card bg-dark shadow rounded">
        <div class="card-body">
            <h1 class="card-title mb-4 text-center text-white">🎓 Enter Student Scores</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('tutor.storeScores') }}">
                @csrf

                <!-- Select Student -->
                <div class="mb-3">
                    <label for="student_id" class="form-label text-white ">Select Student</label>
                    <select name="student_id" id="student_id" class="form-select bg-dark text-light border-light" required>
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Number of courses prompt -->
                <div class="mb-3">
                    <label for="num_courses" class="form-label text-white">Enter number of Courses</label>
                    <input type="number" id="num_courses" class="form-control bg-dark text-light border-light" min="1" max="{{ $courses->count() }}" placeholder="Enter number of courses" required>
                </div>

                <!-- Container where course dropdowns & score inputs will appear -->
                <div id="courses_container"></div>

                <button type="submit" class="btn btn-success w-100 mt-4">✅ Submit Scores</button>
            </form>

            <hr class="my-5">
            <h3 class="text-center text-white">📊 Student Performance Chart</h3>
            <canvas id="performanceChart" class="bg-white rounded" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    const courses = @json($courses);

    // Dynamic course input generator
    document.getElementById('num_courses').addEventListener('input', function () {
        const num = this.value;
        const container = document.getElementById('courses_container');
        container.innerHTML = '';

        for (let i = 0; i < num; i++) {
            container.innerHTML += `
                <div class="row mb-3">
                    <div class="col">
                        <select name="courses[${i}][id]" class="form-select bg-dark text-light border-light" required>
                            <option value="">-- Select Course --</option>
                            ${courses.map(course => `<option value="${course.id}">${course.name}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col">
                        <input type="number" name="courses[${i}][score]" class="form-control bg-dark text-light border-light" placeholder="Score" min="0" max="100" required>
                    </div>
                </div>
            `;
        }
    });

    // Chart rendering
    document.getElementById('student_id').addEventListener('change', function () {
        const studentId = this.value;
        if (!studentId) return;

        fetch(`/tutor/student-scores/${studentId}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(d => d.course_name);
                const scores = data.map(d => d.score);

                const ctx = document.getElementById('performanceChart').getContext('2d');
                if (window.performanceChart) {
                    window.performanceChart.destroy();
                }

                window.performanceChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Score',
                            data: scores,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            });
    });
</script>
@endsection
