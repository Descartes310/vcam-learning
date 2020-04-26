export class User {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    avatar: string;
    job: string;
    description: string;
    facebook: string;
    isActive: boolean;
    created_at: Date;

    public constructor(init?: Partial<User>) {
	    return Object.assign(this, init);
	}

    getName(): string{
        return this.first_name+' '+this.last_name
    }
}
