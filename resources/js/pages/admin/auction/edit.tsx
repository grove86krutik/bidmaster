import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Auction',
        href: "{route('admin.auction.index')}",
    },
];

export default function EditAuction({auction}) {

    const {data, setData, errors, put, reset, processing} = useForm({
        title: auction.title,
        description: auction.description,
    });

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault();
      put(route('admin.auction.update', auction.id), {
        onSuccess: () => {
          reset();
        },
      });
    }

    return (
        <div>
          <Head title="Edit Auction" />
          <div className='container mx-auto p-4'> 
            <div className='flex justify-between items-center mb-4'>
              <a href={route('admin.auction.index')} className='text-gray-500 ml-2'>Back</a>
            </div>
            <div className='flex justify-between items-center mb-4'>
              <h1 className='text-2xl font-bold'>Edit Auction</h1>
            </div>
            <form onSubmit={submit} method='post'>
              <div className='mb-4'>
                <label htmlFor='title' className='block text-sm font-medium text-gray-700'>Title</label>
                <input type='text' id='title' 
                value={data.title} 
                onChange={(e) => setData('title', e.target.value)} 
                name='title' className='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
              </div>
              <div className='mb-4'>
                <label htmlFor='description' className='block text-sm font-medium text-gray-700'>Description</label>
                <textarea id='description'
                value={data.description}
                onChange={(e) => setData('description', e.target.value)}
                name='description' rows={3} className='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'></textarea>
              </div>
              <div className='mb-4'>
                <button type='submit' className='cursor-pointer bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>
                  {processing ? 'Saving...' : 'Save Auction'}
                </button>
              </div>
            </form>
          </div>
      </div>
    );
}