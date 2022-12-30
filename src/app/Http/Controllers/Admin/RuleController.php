<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRuleRequest;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;
use App\Models\Rule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RuleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rules = Rule::all();

        return view('admin.rules.index', compact('rules'));
    }

    public function create()
    {
        abort_if(Gate::denies('rule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rules.create');
    }

    public function store(StoreRuleRequest $request)
    {
        $rule = Rule::create($request->all());

        return redirect()->route('admin.rules.index');
    }

    public function edit(Rule $rule)
    {
        abort_if(Gate::denies('rule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rules.edit', compact('rule'));
    }

    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        $rule->update($request->all());

        return redirect()->route('admin.rules.index');
    }

    public function show(Rule $rule)
    {
        abort_if(Gate::denies('rule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rules.show', compact('rule'));
    }

    public function destroy(Rule $rule)
    {
        abort_if(Gate::denies('rule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rule->delete();

        return back();
    }

    public function massDestroy(MassDestroyRuleRequest $request)
    {
        Rule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
