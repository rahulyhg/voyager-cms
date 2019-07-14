<?php

namespace Tjventurini\VoyagerCMS\GraphQL\Mutations;

use App\User;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Validator;
use Tjventurini\VoyagerProjects\Models\Project;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Tjventurini\VoyagerCMS\GraphQL\Exceptions\ValidationException;

class RegisterUser
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // get data from arguments
        $data = array_get($args, 'data', []);

        // validate the given data
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException("Validation error while registering user.", $validator);
        }

        // get the validated data
        $data = $validator->validated();

        // get the current project
        $project = Project::where('token', request()->header('project-token'))->firstOrFail();

        // get the user role
        $role = Role::where('name', 'user')->firstOrFail();

        // create user from the given data
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'project_id' => $project->id,
            'user_role' => $role->id,
        ]);

        // build response
        return [
            'access_token' => $user->createToken('test')->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
