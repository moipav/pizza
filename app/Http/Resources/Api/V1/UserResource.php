<?php
declare(strict_types=1);
namespace App\Http\Resources\Api\V1;

use App\Models\Role;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'phone' => $this->phone,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'status' => $this->status?->name ?? UserStatus::find($this->status_id)?->name,
            'role' => $this->role?->name ?? Role::find($this->role_id)?->name,
        ];
    }
}
