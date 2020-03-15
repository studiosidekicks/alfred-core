import defaultSettings from '@/settings';

const title = defaultSettings.title || 'CMS';

export default function getPageTitle(key) {
  return `${title}`;
}
