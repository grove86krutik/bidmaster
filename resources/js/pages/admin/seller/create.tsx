import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Seller',
        href: "{route('admin.seller.index')}",
    },
];

export default function CreateAuction() {

    const {data, setData, errors, post, reset, processing} = useForm({
        name: '',
        email: '',
        password: '',
        phone: '',
    });

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault();
      post(route('admin.seller.store'), {
        onSuccess: () => {
          reset();
        },
      });
    }

    return (
        <div>
          <Head title="Create Seller" />
          <div className='container mx-auto p-4'> 
            <div className='flex justify-between items-center mb-4'>
              <a href={route('admin.seller.index')} className='text-gray-500 ml-2'>Back</a>
            </div>
            <div className='flex justify-between items-center mb-4'>
              <h1 className='text-2xl font-bold'>Create Seller</h1>
            </div>

            <form onSubmit={submit} method='post'>
              <div className='mb-4'>
                <label htmlFor='name' className='block text-sm font-medium text-gray-700'>Name</label>
                <input type='text' id='name' 
                value={data.name} 
                onChange={(e) => setData('name', e.target.value)} 
                name='name' className='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
              </div>

              <div className='mb-4'>
                <label htmlFor='email' className='block text-sm font-medium text-gray-700'>Email</label>
                <input type='email' id='email' 
                value={data.email} 
                onChange={(e) => setData('email', e.target.value)} 
                name='email' className='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
              </div>

              <div className='mb-4'>
                <label htmlFor='password' className='block text-sm font-medium text-gray-700'>Password</label>
                <input type='password' id='password' 
                value={data.password} 
                onChange={(e) => setData('password', e.target.value)} 
                name='password' className='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
              </div>

              <div className='mb-4'>
                <label htmlFor='phone' className='block text-sm font-medium text-gray-700'>Phone</label>
                <input type='tel' id='phone' 
                value={data.phone} 
                onChange={(e) => setData('phone', e.target.value)} 
                name='phone' className='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
              </div>
              
              <div className='mb-4'>
                <button type='submit' className='cursor-pointer bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>
                  {processing ? 'Saving...' : 'Create Seller'}
                </button>
              </div>
            </form>
          </div>
      </div>
    );
}