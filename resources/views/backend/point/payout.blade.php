@extends('layouts.backend')
@section('content')
    <div class="row">
        <div class="col-lg-3 m-auto">
            <div class="card bg-dark">
                <div class="card-header bg_yellow text-center">
                    <h4 class="text-white">Total Payable Amount</h4>
                </div>
                <div class="card-body text-center p-3">
                    <h5 class="text-white p-3">Available Points: {{$points->point}}</h5>
                    <h5 class="text-white">Payable Amount:
                        @if ($points->point < 100)
                            {{$points->rate * $points->point}}/=
                            <p class="text-danger mt-2"> <strong>Withdraw Unavailable</strong></p>
                        @else
                            {{$points->rate * $points->point}}/=
                            <p class="text-success mt-2"> Withdraw Available</p>
                        @endif
                    </h5>
                </div>
                <div class="card-footer bg_yellow text-center py-3">
                    <p class="fs_1">A minimum of 100 coins can be withdrawn from your Point</p>
                </div>

            </div>
        </div>
        <div class="col-lg-9 mt-3 m-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Payout Request</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('payoutRequest')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="point">Point</label>
                                    <input type="number" name="point" value="100" id="point" class="form-control">
                                </div>
                                @error('point')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="method">Method</label>
                                    <select name="method" id="method" class="form-control">
                                        <option value="bkash">BKash</option>
                                        <option value="nagad">Nagad</option>
                                        <option value="rocket">Rocket</option>
                                        <option value="upay">Upay</option>
                                    </select>
                                </div>
                                @error('methos')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="number">Number</label>
                                    <input type="text" name="number" id="number" class="form-control">
                                </div>
                                @error('number')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            @if (session('error_message'))
                                <p class="text-danger text-center">{{session('error_message')}}</p>
                            @endif

                            <div class="col-lg-12 d-flex justify-content-center ">
                                <div class="mt-3">
                                    <button class="btn btn-primary">Send Request</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>All Payout Request</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-capitalize">
                        <tr>
                            <th>SL</th>
                            <th>Method</th>
                            <th>Point</th>
                            <th>Number</th>
                            <th>Status</th>
                        </tr>

                        @forelse ($requests as $key=> $request )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$request->method}}</td>
                            <td>{{$request->point}}</td>
                            <td>{{$request->number}}</td>
                            <td><span class="btn btn-warning">Pending</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center"><strong>Not available any Payment Request</strong></td></tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>All Payout History</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-capitalize">
                        <tr>
                            <th>SL</th>
                            <th>Amount</th>
                            <th>Number</th>
                            <th>Method</th>
                            <th>Last Digit</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Status</th>
                        </tr>

                        @forelse ($payoutHistories as $key=> $history )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$history->amount}}</td>
                            <td>{{$history->pay_number}}</td>
                            <td>{{$history->pay_method}}</td>
                            <td>{{$history->last_digit}}</td>
                            <td>{{$history->created_at->format('d/M/Y')}}</td>
                            <td>{{$history->note}}</td>
                            <td>
                                <span class="btn btn-success">Payment Done</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td></td>
                            <td colspan="5" class="text-center"><strong>Not available any Payment History</strong></td>
                            <td></td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@if (session('success'))
<script>
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
    });
    Toast.fire({
    icon: "success",
    title: "{{session('success')}}"
    });
</script>
@endif

@endpush
