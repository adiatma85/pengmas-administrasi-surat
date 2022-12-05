<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;
use App\Http\Resources\RuleResource;
use App\Models\Rule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\ResponseTrait;

class RuleApiController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        // abort_if(Gate::denies('rule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new RuleResource(Rule::all());
        return $this->successResponse("success fetching data", $resource);
    }

    public function store(StoreRuleRequest $request)
    {
        $rule = Rule::create($request->all());

        $resource = new RuleResource($rule);
        return $this->successResponse("success fetching data", $resource);
    }

    public function show(Rule $rule)
    {
        // abort_if(Gate::denies('rule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource = new RuleResource($rule);
        return $this->successResponse("success fetching data", $resource);
    }

    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        $rule->update($request->all());

        $resource = new RuleResource($rule);
        return $this->successResponse("success updating data", $resource);
    }

    public function destroy($ruleId)
    {
        // abort_if(Gate::denies('rule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $rule->delete();
        // Random delete
        Rule::inRandomOrder()->limit(1)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}