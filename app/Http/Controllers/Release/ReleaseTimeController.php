<?php

namespace App\Http\Controllers\Release;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReleaseTimeRequest;
use App\Model\ReleaseTime;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReleaseTimeController extends Controller
{
    private $releaseTime;

    public function __construct(ReleaseTime $releaseTime)
    {
        $this->releaseTime = $releaseTime;
    }

    public function createReleaseTime()
    {
        try {
            $releaseTimes = $this->releaseTime->all();

            $interval = Storage::get('/timeinterval/timeinterval.txt');

            return view('releasetime.release-times', compact('releaseTimes', 'interval'));
        } catch (\Exception $e) {
            // implementar tratamento
        }
    }

    public function storeReleaseTime(ReleaseTimeRequest $request)
    {
        $view = [
            'error' => false
        ];

        try {
            $datas = $request->only(['release_time', 'release_in_sequence']);

            $hour = substr($datas['release_time'], 0, 2);
            $minute = substr($datas['release_time'], 3);

            if ($hour > 23 || $minute > 59) {
                $view['messageError'] = 'O dado informado não corresponde a uma hora valida!';
                $view['error'] = true;

                return json_encode($view);
            }

            $newReleaseTime = $this->releaseTime->create($datas);

            $view['row'] = (string) view('releasetime.release-time-add', compact('newReleaseTime'));

            return json_encode($view);
        } catch (\Exception $e) {
            //  implementar tratamento
        }
    }

    public function storeBetweenRelease(Request $request)
    {
        try {
            $validator = Validator::make($request->only('interval'), [
                'interval' => 'required|integer|min:1|max:60',
            ]);

            if ($validator->fails()) {
                return json_encode(['msg' => 'interval not allowed!']);
            }

            Storage::put('/timeinterval/timeinterval.txt', $request->interval);

            return json_encode(['msg' => 'interval saved with success!']);
        } catch (\Exception $e) {
            //  implementar tratamento
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteReleaseTime($id)
    {
        try {
            $result = $this->releaseTime->destroy($id);

            if ($result) {
                return $id;
            }

            return json_encode(['msg' => 'Error']);
        } catch (\Exception $e) {
            //  impementar
        }
    }
}
