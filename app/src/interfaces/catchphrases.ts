export interface Catchphrase {
	id: number
	title: string
	slug: string
	audio: string
	lyrics: string
	tags_string: null | string
	tags: null | Array<string>
	user: CatchphraseUser
	order: null | string
	created_at: Date
	updated_at: Date
}

export interface CatchphraseUser {
	id: number
	name: string
	username: string
	bio: string
	catchphrases_count: number
	avatar: Avatar
	user_role: string
}

export interface Avatar {
	id: string
	disk_name: string
	file_name: string
	file_size: string
	content_type: string
	title: null
	description: null
	field: string
	sort_order: string
	created_at: Date
	updated_at: Date
	path: string
	extension: string
}
